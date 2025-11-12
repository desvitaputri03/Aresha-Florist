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
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_combinable')->default(false)->after('stok');
            $table->decimal('combined_price_multiplier', 4, 2)->nullable()->after('is_combinable');
            $table->text('combined_description')->nullable()->after('combined_price_multiplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_combinable');
            $table->dropColumn('combined_price_multiplier');
            $table->dropColumn('combined_description');
        });
    }
};
