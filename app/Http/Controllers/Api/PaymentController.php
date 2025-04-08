<?php

// namespace App\Http\Controllers\Api;

// use App\Events\CreateOrder;
// use App\Models\Order;
// use App\Http\Controllers\Controller;
// use App\Models\ListingPackage;
// use Illuminate\Http\Request;
// use Srmklive\PayPal\Services\PayPal as PayPalClient;
// use Session;

// class PaymentController extends Controller
// {
//     public function paymentSuccess(Request $request)
//     {
//         $provider = new PayPalClient($this->setPaypalConfig());
//         $provider->getAccessToken();

//         $orderId = $request->query('token'); // PayPal returns 'token' in URL

//         $response = $provider->capturePaymentOrder($orderId);

//         if (isset($response['status']) && $response['status'] === 'COMPLETED') {
//             // You can save payment info to DB here

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'Payment successful',
//                 'order_id' => $orderId,
//                 'details' => $response
//             ]);
//         } else {
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $response['message'] ?? 'Payment capture failed',
//                 'details' => $response
//             ], 400);
//         }
//     }

//     public function paymentCancel(Request $request)
//     {
//         return response()->json([
//             'status' => 'cancelled',
//             'message' => 'Payment was cancelled by the user.'
//         ], 400);
//     }

//     function payableAmount(): int
//     {
//         $packageId = Session::get('selected_package_id');
//         $package = ListingPackage::findOrFail($packageId);
//         return $package->price;
//     }

//     function setPaypalConfig(): array
//     {
//         return [
//             'mode'    => config('payment.paypal_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
//             'sandbox' => [
//                 'client_id'         => config('payment.paypal_client_id'),
//                 'client_secret'     => config('payment.paypal_secret_key'),
//                 'app_id'            => 'APP-80W284485P519543T',
//             ],
//             'live' => [
//                 'client_id'         => config('payment.paypal_client_id'),
//                 'client_secret'     => config('payment.paypal_secret_key'),
//                 'app_id'            => config('payment.paypal_app_key'),
//             ],

//             'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'), // Can only be 'Sale', 'Authorization' or 'Order'
//             'currency'       => config('payment.paypal_currency'),
//             'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
//             'locale'         => env('PAYPAL_LOCALE', 'en_US'), // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
//             'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true), // Validate SSL when creating api client.
//         ];
//     }

//     public function payWithPaypal(Request $request)
//     {
//         $packageId = $request->input('selected_package_id');
//         $package = ListingPackage::find($packageId);

//         if (!$package) {
//             return response()->json(['error' => 'Invalid package ID'], 400);
//         }

//         $totalPayableAmount = round($package->price * config('payment.paypal_currency_rate'));

//         $provider = new PayPalClient($this->setPaypalConfig());
//         $provider->getAccessToken();

//         $response = $provider->createOrder([
//             'intent' => "CAPTURE",
//             'application_context' => [
//                 'return_url' => route('paypal.success'),
//                 'cancel_url' => route('paypal.cancel'),
//             ],
//             'purchase_units' => [
//                 [
//                     'amount' => [
//                         'currency_code' => config('payment.paypal_currency'),
//                         'value' => $totalPayableAmount
//                     ]
//                 ]
//             ]
//         ]);

//         if (isset($response['id']) && $response['id'] !== null) {
//             foreach ($response['links'] as $link) {
//                 if ($link['rel'] === 'approve') {
//                     return response()->json([
//                         'status' => 'success',
//                         'approval_url' => $link['href'],
//                         'order_id' => $response['id']
//                     ]);
//                 }
//             }
//         } else {
//             logger($response);
//             return response()->json([
//                 'status' => 'error',
//                 'message' => $response['error']['message'] ?? 'Something went wrong',
//             ], 400);
//         }
//     }

//     public function paypalSuccess(Request $request)
//     {
//         $token = $request->query('token');
//         $packageId = $request->query('package_id');

//         if (!$token || !$packageId) {
//             return response()->json(['error' => 'Missing token or package_id'], 400);
//         }

//         $provider = new PayPalClient($this->setPaypalConfig());
//         $provider->getAccessToken();

//         $response = $provider->capturePaymentOrder($token);

//         if (isset($response['status']) && $response['status'] === 'COMPLETED') {
//             $capture = $response['purchase_units'][0]['payments']['captures'][0];

//             $paymentInfo = [
//                 'transaction_id' => $capture['id'],
//                 'payment_method' => 'paypal',
//                 'paid_amount' => $capture['amount']['value'],
//                 'paid_currency' => $capture['amount']['currency_code'],
//                 'payment_status' => 'completed',
//                 'user_id' => auth()->id() ?? 4, // fallback for testing
//                 'package_id' => $packageId,
//             ];

//             event(new CreateOrder($paymentInfo));

//             return response()->json([
//                 'status' => 'success',
//                 'message' => 'Payment successful',
//                 'order_id' => $response['id'],
//                 'details' => $response,
//             ]);
//         }

//         return response()->json(['error' => 'Payment not completed.'], 400);
//     }

//     function paypalCancel()
//     {
//         return redirect()->route('payment.cancel');
//     }

//     /** Pay with Stripe */

//     // function payWithStripe()
//     // {
//     //     // set api key
//     //     Stripe::setApiKey(config('payment.stripe_secret_key'));

//     //     $totalPayableAmount = round(($this->payableAmount() * config('payment.stripe_currency_rate'))) * 100;

//     //     $response = StripeSession::create([
//     //         'line_items' => [
//     //             [
//     //                 'price_data' => [
//     //                     'currency' => config('payment.stripe_currency'),
//     //                     'product_data' => [
//     //                         'name' => 'Package'
//     //                     ],
//     //                     'unit_amount' => $totalPayableAmount
//     //                 ],
//     //                 'quantity' => 1
//     //             ]
//     //         ],
//     //         'mode' => 'payment',
//     //         'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
//     //         'cancel_url' => route('stripe.cancel')
//     //     ]);

//     //     return redirect()->away($response->url);
//     // }
// }


namespace App\Http\Controllers\Api;

use App\Events\CreateOrder;
use App\Http\Controllers\Controller;
use App\Models\ListingPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function payWithPaypal(Request $request)
    {
        $packageId = $request->input('selected_package_id');
        $package = ListingPackage::find($packageId);

        if (!$package) {
            return response()->json(['error' => 'Invalid package ID'], 400);
        }

        // Store package ID in session for future reference if needed
        Session::put('selected_package_id', $packageId);

        $totalPayableAmount = round($package->price * config('payment.paypal_currency_rate'));

        $provider = new PayPalClient($this->setPaypalConfig());
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => route('paypal.success', ['package_id' => $packageId]),
                'cancel_url' => route('paypal.cancel'),
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('payment.paypal_currency'),
                        'value' => $totalPayableAmount
                    ]
                ]
            ]
        ]);

        if (isset($response['id'])) {
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
            'message' => $response['error']['message'] ?? 'Something went wrong'
        ], 400);
    }

    public function paypalSuccess(Request $request)
    {
        $token = $request->query('token');
        $packageId = $request->query('package_id');

        if (!$token || !$packageId) {
            return response()->json(['error' => 'Missing token or package_id'], 400);
        }

        $package = ListingPackage::find($packageId);
        if (!$package) {
            return response()->json(['error' => 'Invalid package ID'], 400);
        }

        $response = $this->capturePaypalOrder($token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $capture = $response['purchase_units'][0]['payments']['captures'][0];

            $paymentInfo = [
                'transaction_id' => $capture['id'],
                'payment_method' => 'paypal',
                'paid_amount' => $capture['amount']['value'],
                'paid_currency' => $capture['amount']['currency_code'],
                'payment_status' => strtolower($response['status']),
                'user_id' => auth()->id(),
                'package_id' => $packageId,
            ];

            event(new \App\Events\CreateOrder($paymentInfo));

            Log::info('✅ PayPal Payment Captured', $response);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful',
                'order_id' => $response['id'],
                'details' => $response,
            ]);
        }

        Log::warning('❌ PayPal Capture Failed', $response);

        return response()->json(['error' => 'Payment not completed.'], 400);
    }

    public function paymentSuccess(Request $request)
    {
        $token = $request->query('token');

        $response = $this->capturePaypalOrder($token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            Log::info('Payment success via paymentSuccess route', $response);

            return response()->json([
                'status' => 'success',
                'message' => 'Payment successful',
                'order_id' => $token,
                'details' => $response
            ]);
        }

        return response()->json([
            'status' => 'error',
            'message' => $response['message'] ?? 'Payment capture failed',
            'details' => $response
        ], 400);
    }

    public function paymentCancel()
    {
        return response()->json([
            'status' => 'cancelled',
            'message' => 'Payment was cancelled by the user.'
        ], 400);
    }

    public function paypalCancel()
    {
        return redirect()->route('payment.cancel');
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