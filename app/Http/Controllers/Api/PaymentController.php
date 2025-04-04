<?php

namespace App\Http\Controllers\Api;

use App\Events\CreateOrder;
use App\Http\Controllers\Controller;
use App\Models\ListingPackage;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Session;

class PaymentController extends Controller
{
    function paymentSuccess()
    {
        return response()->json([
            'message' => 'Payment successful',
            'status' => 'success'
        ]);
    }

    function paymentCancel()
    {
        return response()->json([
            'message' => 'Payment failed ',
            'status' => 'failed'
        ]);
    }

    function payableAmount(): int
    {
        $packageId = Session::get('selected_package_id');
        $package = ListingPackage::findOrFail($packageId);
        return $package->price;
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

    public function payWithPaypal(Request $request)
    {
        $packageId = $request->input('selected_package_id');
        $package = ListingPackage::find($packageId);

        if (!$package) {
            return response()->json(['error' => 'Invalid package ID'], 400);
        }

        $totalPayableAmount = round($package->price * config('payment.paypal_currency_rate'));

        $provider = new PayPalClient($this->setPaypalConfig());
        $provider->getAccessToken();

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
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

        if (isset($response['id']) && $response['id'] !== null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return response()->json([
                        'status' => 'success',
                        'approval_url' => $link['href'],
                        'order_id' => $response['id']
                    ]);
                }
            }
        } else {
            logger($response);
            return response()->json([
                'status' => 'error',
                'message' => $response['error']['message'] ?? 'Something went wrong',
            ], 400);
        }
    }


    function paypalSuccess(Request $request)
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if (isset($response['status']) && $response['status'] === 'COMPLETED') {
            $capture = $response['purchase_units'][0]['payments']['captures'][0];
            $paymentInfo = [
                'transaction_id' => $capture['id'],
                'payment_method' => 'paypal',
                'paid_amount' => $capture['amount']['value'],
                'paid_currency' => $capture['amount']['currency_code'],
                'payment_status' => 'completed'
            ];

            CreateOrder::dispatch($paymentInfo);

            return redirect()->route('payment.success');
        }
    }

    function paypalCancel()
    {
        return redirect()->route('payment.cancel');
    }

    /** Pay with Stripe */

    // function payWithStripe()
    // {
    //     // set api key
    //     Stripe::setApiKey(config('payment.stripe_secret_key'));

    //     $totalPayableAmount = round(($this->payableAmount() * config('payment.stripe_currency_rate'))) * 100;

    //     $response = StripeSession::create([
    //         'line_items' => [
    //             [
    //                 'price_data' => [
    //                     'currency' => config('payment.stripe_currency'),
    //                     'product_data' => [
    //                         'name' => 'Package'
    //                     ],
    //                     'unit_amount' => $totalPayableAmount
    //                 ],
    //                 'quantity' => 1
    //             ]
    //         ],
    //         'mode' => 'payment',
    //         'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
    //         'cancel_url' => route('stripe.cancel')
    //     ]);

    //     return redirect()->away($response->url);
    // }
}