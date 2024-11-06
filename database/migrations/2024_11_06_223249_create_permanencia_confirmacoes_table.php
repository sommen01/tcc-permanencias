<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permanencia_confirmacoes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permanencia_id')->constrained()->onDelete('cascade');
            $table->foreignId('aluno_id')->constrained('users')->onDelete('cascade');
            $table->string('nome_aluno');
            $table->string('email_aluno');
            $table->string('curso');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permanencia_confirmacoes');
    }
};