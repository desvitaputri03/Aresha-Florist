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
        Schema::table('carts', function (Blueprint $table) {
            $table->unsignedBigInteger('combined_with_product_id')->nullable()->after('combined_quantity');
            $table->text('combined_custom_request')->nullable()->after('combined_with_product_id');
            
            $table->foreign('combined_with_product_id')->references('id')->on('products')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropForeign(['combined_with_product_id']);
            $table->dropColumn(['combined_with_product_id', 'combined_custom_request']);
        });
    }
};



