<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipamentoReservas extends Model
{
    protected $fillable = ['fk_reserva', 'fk_equipamento', 'status'];

    public function reserva(){

    	return $this->belongsTo(Reservas::class, 'fk_reserva');
    }

    public function equipamento(){

    	return $this->belongsTo(Equipamentos::class, 'fk_equipamento');
    }

    public function usuario(){

    	return $this->belongsToMany(User::class);
    }
}
