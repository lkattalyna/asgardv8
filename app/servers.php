<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class servers extends Model
{
    //
    protected $guarded = [];
    use SoftDeletes;

    public function marca(){
        return $this->belongsTo(server_marcas::class,'id_marca','id');
    }
    public function modelo(){
        return $this->belongsTo(server_modelos::class,'id_modelo','id');
    }
    public function generacion(){
        return $this->belongsTo(server_modelos::class,'id_modelo','id');
    }
    public function dataCenter(){
        return $this->belongsTo(data_centers::class,'id_data_center','id');
    }
    public function cliente(){
        return $this->belongsTo(clientes::class,'id_cliente','id');
    }
    public function propietario(){
        return $this->belongsTo(propietarios::class,'id_propietario','id');
    }
    public function responsable(){
        return $this->belongsTo(responsables::class,'id_responsable','id');
    }
    public function so(){
        return $this->belongsTo(sistema_operativos::class,'id_so','id');
    }
    public function tipoCliente(){
        return $this->belongsTo(tipos_clientes::class,'id_tipo_cliente','id');
    }
    public function tipoServicio(){
        return $this->belongsTo(tipos_servicios::class,'id_tipo_servicio','id');
    }
    public function tipoRack(){
        return $this->belongsTo(tipos_racks::class,'id_tipo_rack','id');
    }
    public function tipoHardware(){
        return $this->belongsTo(tipos_hardware::class,'id_tipo_hardware','id');
    }
    public function serverEstado(){
        return $this->belongsTo(server_estados::class,'id_estado','id');
    }
    public function raid(){
        return $this->belongsTo(raids::class,'id_raid','id');
    }
    public function controladora(){
        return $this->belongsTo(controladoras::class,'id_controladora','id');
    }
    ///
    /*
    public function Memorias(){
        return $this->HasMany(Memoria::class,'id','id_servidor');
    }*/

    public function memorias(){
        return $this->HasMany(memorias::class,'id_servidor','id');
    }


    public function cpus(){
        return $this->HasMany(cpus::class,'id_servidor','id');
    }
    public function discos(){
        return $this->HasMany(discos::class,'id_servidor','id');
    }
    public function hbas(){
        return $this->HasMany(hbas::class,'id_servidor','id');
    }
    public function nics(){
        return $this->HasMany(nics::class,'id_servidor','id');
    }
}
