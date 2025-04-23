<?php

namespace App\Http\Controllers\Api;

use App\Events\CreateOrder;
use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\ListingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class PaymentController extends Controller
{
    // public function payWithPaypal(Request $request)
    // {
    //     $packageId = $request->input('selected_package_id');
    //     $package = ListingPackage::find($packageId);

    //     if (!$package) {
    //         return response()->json(['error' => 'Invalid package ID'], 400);
    //     }

    //     $totalPayableAmount = round($package->price * config('payment.paypal_currency_rate'));

    //     $provider = new PayPalClient($this->setPaypalConfig());
    //     $provider->getAccessToken();

    //     $response = $provider->createOrder([
    //         'intent' => 'CAPTURE',
    //         'application_context' => [
    //             'return_url' => config('services.react_app.url') . '/paypal-success?package_id=' . $packageId, // Redirect to frontend
    //             'cancel_url' => config('services.react_app.url') . '/paypal-cancel',
    //         ],
    //         'purchase_units' => [
    //             [
    //                 'amount' => [
    //                     'currency_code' => config('payment.paypal_currency'),
    //                     'value' => $totalPayableAmount
    //                 ]
    //             ]
    //         ]
    //     ]);

    //     if (isset($response['id'])) {
    //         // Cache the order session
    //         Cache::put('paypal_session_' . $response['id'], [
    //             'user_id' => Auth::id(),
    //             'package_id' => $packageId,
    //         ], now()->addMinutes(20));

    //         foreach ($response['links'] as $link) {
    //             if ($link['rel'] === 'approve') {
    //                 return response()->json([
    //                     'status' => 'success',
    //                     'approval_url' => $link['href'],
    //                     'order_id' => $response['id']
    //                 ]);
    //             }
    //         }
    //     }

    //     Log::error('❌ PayPal Order Creation Failed', $response);

    //     return response()->json([
    //         'status' => 'error',
    //         'message' => $response['error']['message'] ?? 'Something went wrong during payment creation'
    //     ], 400);
    // }

    public function payWithPaypal(Request $request)
    {
        $packageId = $request->input('selected_package_id');
        $couponCode = $request->input('coupon_code');
        $user = Auth::user();

        $package = ListingPackage::find($packageId);
        if (!$package) {
            return response()->json(['status' => 'error', 'message' => 'Invalid package ID'], 404);
        }

        $finalAmount = $package->price;
        $discountDetails = null;

        // Apply Coupon Logic
        if ($couponCode) {
            $coupon = Coupon::where(['status' => 1, 'code' => $couponCode])->first();

            if (!$coupon || $coupon->start_date > now()->format('Y-m-d') || $coupon->end_date < now()->format('Y-m-d') || $coupon->total_used >= $coupon->quantity) {
                return response()->json(['status' => 'error', 'message' => 'Invalid or expired coupon'], 400);
            }

            if ($coupon->discount_type === 'amount') {
                $finalAmount -= $coupon->discount;
            } elseif ($coupon->discount_type === 'percent') {
                $finalAmount -= ($package->price * $coupon->discount / 100);
            }

            if ($finalAmount < 0) $finalAmount = 0;

            $discountDetails = [
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->code,
                'discount' => $coupon->discount,
                'discount_type' => $coupon->discount_type,
            ];
        }

        $finalAmount = round($finalAmount * config('payment.paypal_currency_rate'), 2);

        // If final price is zero, skip PayPal
        if ($finalAmount == 0) {
            $paymentInfo = [
                'transaction_id' => uniqid(),
                'payment_method' => $package->type === 'free' ? 'free' : 'coupon',
                'paid_amount' => 0,
                'paid_currency' => config('payment.paypal_currency'),
                'payment_status' => 'completed',
                'user_id' => $user->id,
                'package_id' => $package->id,
                'discount_applied' => $discountDetails,
                'coupon_code' => $coupon->code ?? null,
                'discount_type' => $coupon->discount_type ?? null,
                'discount_amount' => $calculatedDiscount ?? 0,
            ];

            CreateOrder::dispatch($paymentInfo);

            return response()->json([
                'status' => 'success',
                'message' => 'Package subscribed successfully without payment',
                // 'redirect_to' => '/thank-you-or-dashboard'
            ]);
        }

        // Create PayPal Order
        $provider = new PayPalClient($this->setPaypalConfig());
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => config('services.react_app.url') . '/paypal-success?package_id=' . $packageId,
                'cancel_url' => config('services.react_app.url') . '/paypal-cancel',
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('payment.paypal_currency'),
                        'value' => $finalAmount
                    ]
                ]
            ]
        ]);

        if (isset($response['id'])) {
            Cache::put('paypal_session_' . $response['id'], [
                'user_id' => $user->id,
                'package_id' => $packageId,
                'discount_applied' => $discountDetails
            ], now()->addMinutes(20));

            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return response()->json([
                        'status' => 'success',
                        'approval_url' => $link['href'],
                        'order_id' => $response['id']
                    ]);
                }
            }
        }

        Log::error('PayPal Order Creation Failed', $response);

        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong during PayPal payment creation.'
        ], 400);
    }

    public function paypalSuccess(Request $request)
    {
        $token = $request->query('token');
        $packageId = $request->query('package_id');

        if (!$token || !$packageId) {
            return response()->json(['error' => 'Missing token or package_id'], 400);
        }

        // Pull session from cache
        $session = Cache::pull('paypal_session_' . $token);

        if (!$session || Auth::id() !== $session['user_id']) {
            return response()->json(['error' => 'Unauthorized or expired session'], 403);
        }

        $package = ListingPackage::find($packageId);
        if (!$package) {
            return response()->json(['error' => 'Invalid package ID'], 400);
        }

        $provider = new PayPalClient($this->setPaypalConfig());
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $capture = $response['purchase_units'][0]['payments']['captures'][0];

            $paymentInfo = [
                'transaction_id' => $capture['id'],
                'payment_method' => 'paypal',
                'paid_amount' => $capture['amount']['value'],
                'paid_currency' => $capture['amount']['currency_code'],
                'payment_status' => strtolower($response['status']),
                'user_id' => Auth::id(),
                'package_id' => $packageId,
            ];

            // Fire event to create the order
            event(new \App\Events\CreateOrder($paymentInfo));

            Log::info('✅ PayPal Payment Captured', $response);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful',
                'order_id' => $response['id'],
                'details' => $response,
            ]);
        }

        Log::warning('❌ PayPal capture failed', $response);

        return response()->json([
            'status' => 'error',
            'message' => 'Payment capture failed'
        ], 400);
    }

    public function getPaypalSession(Request $request)
    {
        $token = $request->query('token');

        if (!$token) {
            return response()->json(['error' => 'Missing token'], 400);
        }

        $session = Cache::get('paypal_session_' . $token); // Just get (not pull)

        if (!$session) {
            return response()->json(['error' => 'Session expired or not found'], 404);
        }

        return response()->json([
            'status' => 'success',
            'session' => $session
        ]);
    }


    private function capturePaypalOrder(string $token)
    {
        $provider = new PayPalClient($this->setPaypalConfig());
        $provider->getAccessToken();

        return $provider->capturePaymentOrder($token);
    }

    function setPaypalConfig(): array
    {
        return [
            'mode'    => config('payment.paypal_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
            'sandbox' => [
                'client_id'         => config('payment.paypal_client_id'),
                'client_secret'     => config('payment.paypal_secret_key'),
                'app_id'            => 'APP-80W284485P519543T',
            ],
            'live' => [
                'client_id'         => config('payment.paypal_client_id'),
                'client_secret'     => config('payment.paypal_secret_key'),
                'app_id'            => config('payment.paypal_app_key'),
            ],

            'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
            'currency'       => config('payment.paypal_currency'),
            'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
            'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
            'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
        ];
    }
}