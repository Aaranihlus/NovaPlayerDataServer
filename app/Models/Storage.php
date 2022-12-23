<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model {
  use HasFactory;
  protected $table = 'item_user';

  protected $fillable = [
    'user_id',
    'item_id'
  ];

  protected $hidden = [
    'updated_at',
    'created_at',
  ];

}
