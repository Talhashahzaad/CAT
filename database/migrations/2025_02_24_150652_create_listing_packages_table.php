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
            $table->enum('type', ['free', 'paid']);
            $table->string('name');
            $table->double('price');
            $table->boolean('status');
            $table->integer('number_of_days');
            $table->integer('num_of_listing');
            $table->integer('cat_ecommarce');
            $table->integer('cat_pro_social_media');
            $table->integer('social_media_post');
            $table->integer('live_chat');;
            $table->integer('multiple_locations');
            $table->integer('featured_listing');
            $table->softDeletes();
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