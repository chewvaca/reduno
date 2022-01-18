<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Intimacion extends Pivot
{
    //
    public $table = 'intimaciones';
    public function archivo()
    {
        return $this->belongsTo(Archivo::class);
    }
    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }
}
