<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up() {
      Schema::create('item_user', function (Blueprint $table) {
        $table->id();
        $table->foreignId('item_id');
        $table->foreignId('user_id');
        $table->timestamps();
      });
    }

    public function down() {
      Schema::dropIfExists('item_user');
    }
};
