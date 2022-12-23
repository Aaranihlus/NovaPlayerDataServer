<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model {
  use HasFactory;
  protected $table = 'shop';

  protected $hidden = [
    'updated_at',
    'created_at',
  ];

}
