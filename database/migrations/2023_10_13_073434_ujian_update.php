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
      Schema::create('ujians', function (Blueprint $table) {
          $table->id();
          $table->unsignedBigInteger('mapel_id');
          $table->unsignedBigInteger('id_user');
          $table->string('nama_user');
          $table->string('nama_ujian');
          $table->string('tipe_ujian');
          $table->timestamps();

          $table->foreign('id_user')->references('id')->on('users');
          $table->foreign('mapel_id')->references('id')->on('mapels');
      });//
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ujians');  //
    }
};
