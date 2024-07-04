<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermanenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permanencias', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('disciplina');
            $table->string('email_do_professor');
            $table->boolean('status');
            $table->dateTime('data');
            $table->string('curso');
            $table->string('turno');
            $table->string('nome_do_professor');
            $table->integer('dia_semana'); // novo campo para dia da semana
            $table->time('hora_inicio'); // novo campo para hora de início
            $table->time('hora_fim'); // novo campo para hora de término
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
        Schema::dropIfExists('permanencias');
    }
}
