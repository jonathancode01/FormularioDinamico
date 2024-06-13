<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcaoForm extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'titulo',
        'opcao'
    ];

    public function formulario(){
        return $this->belongsTo(Formulario::class);
    }

    public function OpcaoForm(){
        return $this->hasMany(OpcaoForm::class);
    }
}
