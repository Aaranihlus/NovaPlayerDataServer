<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable {

    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
      'username',
      //'email',
      'password',
      'credits',
      'experience',
      'chest_rig',
      'backpack',
      'primary_weapon',
      'secondary_weapon',
      'inventory',
      'char_head',
      'char_skin',
      'char_shirt',
      'char_pants',
      'char_boots'
    ];

    protected $hidden = [
      'password',
      //'remember_token',
    ];

    protected $casts = [
      //'email_verified_at' => 'datetime',
    ];
}
