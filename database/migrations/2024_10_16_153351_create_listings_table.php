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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->foreignId('location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('professional_affiliations_id')->nullable();
            $table->foreignId('practitioner_id')->nullable();
            $table->foreignId('package_id')->nullable();
            $table->foreignId('tag_id')->nullable();
            $table->string('image');
            $table->string('thumbnail_image');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('phone');
            $table->string('email');
            $table->string('address');
            $table->string('price_range');
            $table->text('website');
            $table->text('facebook_link');
            $table->text('tiktok_link');
            $table->text('instagram_link');
            $table->text('youtube_link');
            $table->boolean('is_verified')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->integer('views');
            $table->text('google_map_embed_code')->nullable();
            $table->string('file')->nullable();
            $table->date('expired_date');
            $table->string('seo_title');
            $table->string('seo_description');
            $table->boolean('status')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};