<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
      Schema::create('users', function (Blueprint $table) {
        $table->id();
        $table->string('username');
        $table->string('password');
        $table->string('credits');
        $table->string('experience');

        $table->string('chest_rig');
        $table->string('backpack');
        $table->string('primary_weapon');
        $table->string('secondary_weapon');
        $table->string('inventory');

        $table->string('char_skin');
        $table->string('char_shirt');
        $table->string('char_pants');
        $table->string('char_boots');
        $table->string('char_head');


        $table->timestamps();
      });
    }

    public function down() {
      Schema::dropIfExists('users');
    }

};
