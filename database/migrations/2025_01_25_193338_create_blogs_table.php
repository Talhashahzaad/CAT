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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->foreignId('blog_category_id')->constrained('blog_categories')->onDelete('cascade');
            $table->string('title');
            $table->string('views')->default(0);
            $table->string('slug');
            $table->text('description');
            $table->boolean('status');
            $table->boolean('is_popular');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};