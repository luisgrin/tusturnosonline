<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{
    protected $table = 'crm_atributo';
    protected $fillable = ['nom','user_id','tipo'];

  
}
