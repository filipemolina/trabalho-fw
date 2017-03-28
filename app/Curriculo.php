<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Curriculo extends Model
{
    //

    protected $fillable = [
    	'nome',
    	'nascimento',
    	'cpf',
    	'rg',
    	'pis',
    	'ctps',
    	'titulo',
    	'indicacao_politica',
    	'formacao',
    	'telefone_1',
    	'telefone_2',
    	'rua',
    	'numero',
    	'complemento',
    	'bairro',
    	'cep',
    	'comentarios',
        'sexo',
    ];

    public function areas()
    {
        return $this->belongsToMany('App\Area');
    }
}
