<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RespFormulario extends Model
{
    use HasFactory;

    protected $table = 'respform';

    protected $fillable = ['resp', 'resp_tipo'];

}
