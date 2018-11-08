<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reservas extends Model
{
    protected $fillable = ['fk_usuario', 'fk_ambiente', 'data_inicial', 'data_final', 'observacao', 'feedback', 'status'];

    public function equipamento(){

    	return $this->belongsToMany(Equipamentos::class,'equipamento_reservas','fk_reserva','fk_equipamento');
    }

    public function ambiente(){

    	return $this->belongsToMany(Ambiente::class,'ambiente_reservas','fk_reserva','fk_ambiente');
    }

    public function usuario(){

    	return $this->belongsTo(User::class, 'fk_usuario');
    }

    public function equipamentoReserva(){

    	return $this->hasMany(EquipamentoReservas::class, 'fk_reserva');
    }

    public function ambienteReserva(){
        
        return $this->hasMany(AmbienteReserva::class,'fk_reserva');
    }
    public function usuarioRetirada(){
        
        return $this->belongsTo(User::class,'fk_usuario_retirada');
    }

    public function usuarioEntrega(){
        
        return $this->belongsTo(User::class,'fk_entrega');
    }
    
}
