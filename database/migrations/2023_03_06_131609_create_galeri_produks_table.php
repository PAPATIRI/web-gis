<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_galeri_produk', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fkid_toko')->index();
            $table->string('nama_produk');
            $table->string('deskripsi_produk')->nullable();
            $table->string('gambar_produk');
            $table->timestamps();
            $table->foreign('fkid_toko')->references('id')->on('tbl_toko')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_galeri_produk');
    }
};
