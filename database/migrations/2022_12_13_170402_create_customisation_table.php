<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
      Schema::create('customisation', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('level');
        $table->timestamps();
      });
    }

    public function down() {
      Schema::dropIfExists('customisation');
    }
};
