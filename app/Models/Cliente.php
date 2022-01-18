<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $hidden = ['created_at','updated_at'];

    protected $fillable = [
        'dni',
        'nombre',
    ];


    public function localizacion(){
        return $this->hasMany(Localizacion::class);
    }
}
