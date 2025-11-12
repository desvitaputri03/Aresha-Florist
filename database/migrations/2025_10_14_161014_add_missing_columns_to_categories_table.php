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
        Schema::table('categories', function (Blueprint $table) {
            $table->text('deskripsi')->nullable()->after('name');
            $table->string('slug')->nullable()->after('deskripsi');
            $table->string('warna')->nullable()->after('slug');
            $table->string('ikon')->nullable()->after('warna');
            $table->boolean('is_active')->default(true)->after('ikon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn(['deskripsi', 'slug', 'warna', 'ikon', 'is_active']);
        });
    }
};
