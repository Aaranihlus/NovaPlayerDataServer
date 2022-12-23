<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customisation extends Model {
  use HasFactory;
  protected $table = 'customisation';

  protected $hidden = [
    'updated_at',
    'created_at',
  ];

}
