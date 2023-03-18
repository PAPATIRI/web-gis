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
        Schema::create('tbl_toko', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fkid_user')->index();
            $table->string('nama_toko');
            $table->string('slug');            
            $table->string('lokasi_toko');
            $table->string('alamat_detail_toko');
            $table->string('website_toko');
            $table->string('kontak_toko');
            $table->longText('deskripsi_toko');
            $table->string('jam_buka');
            $table->string('jam_tutup');
            $table->boolean('status_toko');
            $table->string('sampul_toko')->nullable();
            $table->timestamps();
            $table->foreign('fkid_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('toko');
    }
};
