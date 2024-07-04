<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermanenciasTable extends Migration
{
    public function up()
    {
        Schema::create('permanencias', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('disciplina');
            $table->string('email_do_professor');
            $table->boolean('status');
            $table->date('data');
            $table->string('curso');
            $table->string('turno');
            $table->string('nome_do_professor');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permanencias');
    }
}
