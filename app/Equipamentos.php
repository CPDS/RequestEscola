<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipamentos extends Model
{
    protected $fillable = ['fk_tipo_equipamento', 'fk_local', 'num_tombo', 'codigo', 'status', 'marca'];

    public function local(){

    	return $this->belongsTo(Locais::class, 'fk_local');
    }

    public function tipoEquipamento(){
    	
    	return $this->belongsTo(tipoEquipamentos::class,'fk_tipo_equipamento');
    }

    

}
