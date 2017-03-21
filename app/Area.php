<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    // Campos liberados para Mass Assignment

    protected $fillable = ['descricao'];

    public function curriculos()
    {
    	return $this->belongsToMany('App\Curriculo');
    }
}
