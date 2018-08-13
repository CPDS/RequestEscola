<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEquipamentos extends Model
{
    protected $fillable =[
    	'nome',
    	'observacao',
    	'status'
    ];
}
