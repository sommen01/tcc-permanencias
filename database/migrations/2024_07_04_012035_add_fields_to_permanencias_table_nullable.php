<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPermanenciasTableNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('permanencias', function (Blueprint $table) {
            $table->integer('dia_semana')->nullable()->after('turno'); 
            $table->time('hora_inicio')->nullable()->after('dia_semana'); 
            $table->time('hora_fim')->nullable()->after('hora_inicio'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('permanencias', function (Blueprint $table) {
            $table->dropColumn('dia_semana');
            $table->dropColumn('hora_inicio');
            $table->dropColumn('hora_fim');
        });
    }
}
