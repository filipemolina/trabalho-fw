<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    
	protected $fillable = ['descricao'];

	public function curriculos()
	{
		return $this->hasMany('App\Curriculo', 'encaminhado');
	}

}
