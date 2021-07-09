<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('vague.table_names.user_roles', 'user_roles'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('role');
            $table->timestamps();
        });

        Schema::create(config('vague.table_names.user_permissions', 'user_permissions'), function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('permission');
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
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('user_permissions');
    }
}
