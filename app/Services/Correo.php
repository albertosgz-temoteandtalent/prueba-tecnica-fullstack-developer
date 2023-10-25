<?php

namespace App\Services;

use App\Models\PerfilUsuario;

class Correo
{
    static function sendEmail(PerfilUsuario $perfilUsuario) {
        sleep(5);
        logger('Mensaje enviado al correo: ' . $perfilUsuario->correo);
    }
}
