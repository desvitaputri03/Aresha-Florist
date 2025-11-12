<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->decimal('harga_diskon', 12, 2)->nullable();
            $table->unsignedBigInteger('id_kategori');
            $table->string('gambar')->nullable();
            $table->integer('stok')->default(0);
            $table->timestamps();

            // relasi ke categories
            $table->foreign('id_kategori')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
