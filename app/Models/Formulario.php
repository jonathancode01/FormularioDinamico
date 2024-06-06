<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Formulario extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo'

    ];

    public function campos()
    {
        return $this->hasMany(CampoFormulario::class, 'formulario_id');
    }

}
