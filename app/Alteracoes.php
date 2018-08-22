<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alteracoes extends Model
{
    protected $fillable = ['fk_reserva_equipamento', 'fk_usuario'];

    public function usuario(){

    	return $this->belongsTo(User::class, 'fk_usuario');
    }

    public function equipamentoReserva(){

    	return $this->belongsTo(EquipamentoReservas::class, 'fk_reserva_equipamento');
    }
}
