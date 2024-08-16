<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespFormulario extends Model
{
    use HasFactory;

    protected $table = 'respform';

    protected $fillable = ['resp', 'resp_tipo', 'formulario_id', 'campo_id'];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    public function campo()
    {
        return $this->belongsTo(CampoFormulario::class, 'campo_id');
    }
}


