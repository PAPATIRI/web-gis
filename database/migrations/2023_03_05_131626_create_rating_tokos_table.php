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
        Schema::create('tbl_rating_toko', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fkid_toko')->index();
            $table->double('rating_toko');
            $table->string('komentar');
            $table->string('nama');
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
        Schema::dropIfExists('tbl_rating_toko');
    }
};
