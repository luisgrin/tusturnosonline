<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteAtributo extends Model
{
	protected $table = 'r_cliente_crm_atributo';

    public function cliente()
    {
        return $this->belongsTo('Cliente','cliente_id');
    }	
}
