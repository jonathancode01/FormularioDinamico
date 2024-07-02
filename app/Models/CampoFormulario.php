<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampoFormulario extends Model
{
    use HasFactory;

    protected $table = 'campos_formulario';

    protected $fillable = ['formulario_id', 'titulo', 'tipo'];


    public function formulario()
    {
        return $this->belongsTo(Formulario::class);
    }

    public function options(){
        return $this->hasMany(SelectModel::class);
    }
}
