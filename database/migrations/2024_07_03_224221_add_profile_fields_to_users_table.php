<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProfileFieldsToUsersTable extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('curso')->nullable();
            $table->string('periodo')->nullable();
            $table->string('turno')->nullable();
            $table->boolean('profile_completed')->default(false);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['curso', 'periodo', 'turno', 'profile_completed']);
        });
    }
}

