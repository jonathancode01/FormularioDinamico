<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampoFormulario extends Model
{
    use HasFactory;

    protected $table = 'campos_formulario';

    protected $fillable = ['formulario_id', 'titulo', 'tipo'];

    protected $casts = [

        'opcoes' => 'array'
    ];

    public function formulario()
    {
        return $this->belongsTo(Formulario::class, 'formulario_id');
    }

    public function opcoes()
        {
            return $this->hasMany(OpcaoForm::class, 'element_id');
        }

}
