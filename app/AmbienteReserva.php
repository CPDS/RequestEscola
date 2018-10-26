<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmbienteReserva extends Model
{
    public function reserva(){

    	return $this->belongsTo(Reservas::class, 'fk_reserva');
    }

    public function ambiente(){

    	return $this->belongsTo(Ambiente::class, 'fk_ambiente');
    }
}
