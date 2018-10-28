<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    protected $fillable = ['fk_usuario', 'fk_ambiente', 'data_inicial', 'data_final', 'observacao', 'feedback', 'status'];

    public function equipamento(){

    	return $this->belongsToMany(Equipamentos::class);
    }

    public function usuario(){

    	return $this->belongsTo(User::class, 'fk_usuario');
    }

    public function equipamentoReserva(){

    	return $this->hasMany(EquipamentoReservas::class, 'fk_equipamento');
    }

    public function ambienteReserva(){
        
        return $this->hasMany(AmbienteReserva::class,'fk_reserva');
    }
    
}
