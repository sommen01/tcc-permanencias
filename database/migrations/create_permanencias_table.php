<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('permanencias', function (Blueprint $table) {
            $table->id();
            $table->string('foto');
            $table->string('nome');
            $table->string('email');
            $table->boolean('status');
            $table->date('data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permanencias');
    }
};
