<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SelectModel extends Model
{
    use HasFactory;

    protected $fillable = [
        'campo_formulario_id',
        'option_text'
    ];

    public function campoFormulario(){
        return $this->belongsTo(CampoFormulario::class);
    }
}
