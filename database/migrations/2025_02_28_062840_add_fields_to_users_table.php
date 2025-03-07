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
        Schema::table('users', function (Blueprint $table) {
            $table->after('password', function (Blueprint $table) {
                $table->string('heard_about_options')->nullable();
                $table->string('business_location')->nullable();
                $table->string('business_size')->nullable();
                $table->string('premises_count')->nullable();
                $table->string('main_location')->nullable();
                $table->string('age_group')->nullable();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'heard_about_options',
                'treatment_categories',
                'business_location',
                'business_size',
                'premises_count',
                'main_location',
                'age_group',
            ]);
        });
    }
};