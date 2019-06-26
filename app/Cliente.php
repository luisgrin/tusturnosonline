<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//hola
class Cliente extends Model
{
	protected $table = 'cliente';
	protected $fillable = ['nom','user_id'];
}
