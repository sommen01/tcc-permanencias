<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permanencias', function (Blueprint $table) {
            $table->string('sala')->nullable()->after('duracao');
        });
    }

    public function down()
    {
        Schema::table('permanencias', function (Blueprint $table) {
            $table->dropColumn('sala');
        });
    }
};