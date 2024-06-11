<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resp_Formulario extends Model
{
    use HasFactory;

    protected $table = 'resp_formularios';

    protected $fillable = [
        'texto',
        'textoarea',
        'multiplo',
    ];

}
