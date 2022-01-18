<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;

    protected $table = 'contratos';
    protected $hidden = ['created_at','updated_at'];

    protected $fillable = [
        'localizacion_id',
        'pppoe',
    ];

    public function localizacion(){
        return $this->belongsTo(Localizacion::class);
    }
}
