<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;
use App\Models\Contrato;

class Localizacion extends Model
{

    protected $table = 'localizaciones';
    protected $hidden = ['created_at','updated_at'];

    protected $fillable = [
        'cliente_id',
        'direccion',
        'email',
        'telefono',
    ];
    use HasFactory;

    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }
    public function contrato(){
        return $this->hasOne(Contrato::class);
    }
}
