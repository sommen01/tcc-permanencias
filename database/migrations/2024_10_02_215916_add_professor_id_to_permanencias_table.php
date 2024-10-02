<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfessorIdToPermanenciasTable extends Migration
{
    public function up()
    {
        Schema::table('permanencias', function (Blueprint $table) {
            $table->unsignedBigInteger('professor_id')->nullable()->after('id');
            $table->foreign('professor_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('permanencias', function (Blueprint $table) {
            $table->dropForeign(['professor_id']);
            $table->dropColumn('professor_id');
        });
    }
}
