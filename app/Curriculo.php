<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curriculo extends Model
{
    // Necessário para o SoftDeletes

    use SoftDeletes;

    protected $dates = [
        'deleted_at',
        'nascimento'
    ];

    //

    protected $fillable = [
    	'nome',
    	'nascimento',
    	'cpf',
        'pcd',
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

    // Mutator necessário para que o CPF seja único à menos que seja vazio
    // Essa função será chamada sempre que o usuário tentar alterar ou cadastrar
    // um novo CPF

    public function setCpfAttribute($valor)
    {
        if(empty($valor))
            $this->attributes['cpf'] = NULL;
        else
            $this->attributes['cpf'] = $valor;
    }

    // Retorna as áreas de atuação às quais esse curriculo pertence

    public function areas()
    {
        return $this->belongsToMany('App\Area');
    }

    // Retorna o usuário que deletou este currículo

    public function quem_deletou()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // Retorna a empresa para a qual esse currículo foi encaminhado

    public function empresa()
    {
        return $this->belongsTo('App\Empresa', 'encaminhado');
    }

}
