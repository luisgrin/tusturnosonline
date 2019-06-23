<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClienteAtributo extends Model
{
	protected $table = 'r_cliente_crm_atributo';
	protected $with = ['atributo'];
	protected $fillable = ['cliente_id','crm_atributo_id','valor'];

    public function cliente()
    {
        return $this->belongsTo('App\Cliente','cliente_id');
    }

    public function atributo()
    {
        return $this->belongsTo('App\Atributo','crm_atributo_id');
    }    
}
