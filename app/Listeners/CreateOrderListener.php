<?php

namespace App\Listeners;

use App\Events\CreateOrder;
use App\Models\Order;
use App\Models\ListingPackage;
use App\Models\Subscription;
use Carbon\Carbon;

class CreateOrderListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */

    public function handle(CreateOrder $event): void
    {
        \Log::info('✅ CreateOrder event triggered:', $event->paymentInfo);

        $info = $event->paymentInfo;

        // ✅ Prevent duplicate order creation
        $existingOrder = Order::where('transaction_id', $info['transaction_id'])->first();
        if ($existingOrder) {
            \Log::warning('⚠️ Order already exists with transaction ID: ' . $info['transaction_id']);

            // ✅ Ensure subscription still gets created/updated for this order
            $this->createOrUpdateSubscription($existingOrder, $info['package_id']);
            return;
        }

        // ✅ Fetch the selected package
        $package = ListingPackage::find($info['package_id']);
        if (!$package) {
            \Log::error('❌ Package not found for ID: ' . $info['package_id']);
            return;
        }

        // ✅ Create new order
        $order = new Order();
        $order->order_id = uniqid();
        $order->transaction_id = $info['transaction_id'];
        $order->user_id = $info['user_id'];
        $order->package_id = $package->id;
        $order->payment_method = $info['payment_method'];
        $order->payment_status = $info['payment_status'];
        $order->base_amount = $package->price;
        $order->base_currency = config('settings.site_default_currency', 'USD');
        $order->paid_amount = $info['paid_amount'];
        $order->paid_currency = $info['paid_currency'];
        $order->purchase_date = now();

        \Log::info('Saving order data:', $order->toArray());
        $order->save();
        \Log::info('✅ Order saved successfully: ID ' . $order->id);

        // ✅ Call method to create or update subscription
        $this->createOrUpdateSubscription($order, $package->id);
    }
    private function createOrUpdateSubscription(Order $order, int $packageId): void
    {
        try {
            $package = ListingPackage::find($packageId);
            if (!$package) {
                \Log::error('❌ Package not found while creating subscription for user_id: ' . $order->user_id);
                return;
            }

            $subscription = Subscription::updateOrCreate(
                ['user_id' => $order->user_id],
                [
                    'package_id' => $package->id,
                    'order_id' => $order->id,
                    'purchase_date' => $order->purchase_date,
                    'expire_date' => $package->number_of_days == -1
                        ? null
                        : Carbon::parse($order->purchase_date)->addDays($package->number_of_days),
                    'status' => 1,
                ]
            );

            \Log::info('✅ Subscription updated or created for user_id: ' . $order->user_id . ', Subscription ID: ' . $subscription->id);
        } catch (\Exception $e) {
            \Log::error('❌ Failed to update/create subscription: ' . $e->getMessage());
        }
    }
}