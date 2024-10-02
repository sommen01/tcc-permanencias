<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveFotoFromPermanenciasTable extends Migration
{
    public function up()
    {
        Schema::table('permanencias', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }

    public function down()
    {
        Schema::table('permanencias', function (Blueprint $table) {
            $table->string('foto')->nullable();
        });
    }
}