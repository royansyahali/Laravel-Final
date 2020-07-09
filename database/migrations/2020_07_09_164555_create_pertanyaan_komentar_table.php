<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePertanyaanKomentarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertanyaan_komentar', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("pertanyaan_id");
            $table->unsignedBigInteger("komentar_id");
            $table->foreign("pertanyaan_id")->references("id")->on("pertanyaans")->onDelete("cascade");
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
        Schema::dropIfExists('pertanyaan_komentar');
    }
}
