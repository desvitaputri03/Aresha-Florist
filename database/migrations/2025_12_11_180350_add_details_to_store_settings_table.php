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
        Schema::table('store_settings', function (Blueprint $table) {
            $table->string('address')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('email')->nullable();
            $table->string('operating_hours')->nullable();
            $table->string('google_maps_link')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->text('about_us_description')->nullable();
            $table->text('history')->nullable();
            $table->text('vision')->nullable();
            $table->text('mission')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn([
                'address',
                'phone_number',
                'email',
                'operating_hours',
                'google_maps_link',
                'whatsapp_number',
                'about_us_description',
                'history',
                'vision',
                'mission',
            ]);
        });
    }
};
