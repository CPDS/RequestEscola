<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Manutencoes extends Model
{
    protected $fillable = ['data', 'descricao', 'destino', 'fk_usuario', 'fk_equipamento', 'status'];

    public function equipamento(){

    	return $this->belongsTo(Equipamentos::class, 'fk_equipamento');
    }

    public function usuario(){

    	return $this->belongsTo(User::class, 'fk_usuario');
    }
}
