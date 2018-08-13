<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Locais extends Model
{
    protected $fillable =[
    	'nome',
    	'observacao',
    	'status'
    ];

}
