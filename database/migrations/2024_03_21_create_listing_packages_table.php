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
        Schema::create('listing_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('type')->default('paid');
            $table->integer('number_of_days');
            $table->integer('num_of_listing');
            $table->boolean('cat_ecommarce')->default(false);
            $table->boolean('cat_pro_social_media')->default(false);
            $table->boolean('social_media_post')->default(false);
            $table->boolean('featured_listing')->default(false);
            $table->boolean('multiple_locations')->default(false);
            $table->boolean('live_chat')->default(false);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listing_packages');
    }
};
