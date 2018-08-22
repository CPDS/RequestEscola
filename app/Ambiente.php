<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ambiente extends Model
{
    public $fillable = ['fk_local', 'tipo', 'descricao', 'numero_ambiente', 'status'];

    public function local(){

    	return $this->belongsTo(Locais::class, 'fk_local');
    }
    
}
