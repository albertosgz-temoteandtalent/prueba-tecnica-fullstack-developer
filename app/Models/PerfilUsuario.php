<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilUsuario extends Model
{
    use HasFactory;

    protected $table = 'perfil_usuarios';

    function imagen() {
        return $this->hasOne('imagen', 'imagen_id');
    }
}
