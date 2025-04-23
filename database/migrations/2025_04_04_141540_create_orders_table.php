<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('transaction_id');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('package_id')->constrained('listing_packages');
            $table->string('payment_method');
            $table->enum('payment_status', ['completed', 'pending', 'failed']);
            $table->double('base_amount');
            $table->string('base_currency');
            $table->double('paid_amount');
            $table->string('paid_currency');
            $table->decimal('discount_amount', 10, 2)->nullable();
            $table->string('discount_type')->nullable(); // 'amount' or 'percent'
            $table->string('coupon_code')->nullable();
            $table->timestamp('purchase_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};