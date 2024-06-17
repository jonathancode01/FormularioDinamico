<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpcoesForm extends Model
{
    use HasFactory;

    protected $table = 'opcoes_form';

    protected $fillable = [
        'element_id',
        'checkbox',
    ];

    public function campo(){
        return $this->belongsTo(CampoFormulario::class, 'element_id', 'id');
    }
}
