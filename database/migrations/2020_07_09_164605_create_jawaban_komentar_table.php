<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJawabanKomentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jawaban_komentar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("jawaban_id");
            $table->unsignedBigInteger("komentar_id");
            $table->foreign("jawaban_id")->references("id")->on("jawabans")->onDelete("cascade");
            $table->foreign("komentar_id")->references("id")->on("komentars")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jawaban_komentar');
    }
}
