<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AmbienteReserva extends Model
{
    public function reserva(){

    	return $this->belongsTo(User::class, 'fk_reserva');
    }

    public function ambiente(){

    	return $this->belongsTo(User::class, 'fk_ambiente');
    }
}
