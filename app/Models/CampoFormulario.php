<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampoFormulario extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_formulario',
        'texto',
        'textoarea',
        'multiplo',
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class, 'formulario_id');
    }
}
