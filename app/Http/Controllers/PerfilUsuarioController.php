<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePerfilUsuarioRequest;
use App\Http\Requests\UpdatePerfilUsuarioRequest;
use App\Http\Resources\PerfilUsuarioResource;
use App\Jobs\ProcesarCorreo;
use App\Models\imagen;
use App\Models\PerfilUsuario;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PerfilUsuarioController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePerfilUsuarioRequest $request)
    {
        $nombre = $request->get('nombre');
        $apellidos = $request->get('apellidos');
        $telefono = $request->get('telefono');
        $correo = $request->get('correo');
        $urlImagen = $request->get('imagen');

        if (!$nombre && !$apellidos && !$telefono && !$correo && !$urlImagen) {
            return new Response('No se puede crear un perfil con todos los campos vacíos', 400);
        }

        $imagen = null;
        if ($urlImagen) {
            $nombreImagen = last(explode('/', $urlImagen));
            if (Storage::url('imagenes/' . $nombreImagen) == $urlImagen) {
                $imagen = imagen::where('nombre', $nombreImagen)->first();
            }
        }

        $usuarioPerfil = PerfilUsuario::where('nombre', $nombre)
            ->where('apellidos', $apellidos)
            ->where('telefono', $telefono)
            ->where('correo', $correo)
            ->where('imagen_id', optional($imagen)->id)
            ->first();

        $usuarioCreado = false;
        if (!$usuarioPerfil) {
            $usuarioPerfil = new PerfilUsuario();
            $usuarioPerfil->nombre = $nombre;
            $usuarioPerfil->apellidos = $apellidos;
            $usuarioPerfil->telefono = $telefono;
            $usuarioPerfil->correo = $correo;
            $usuarioPerfil->imagen_id = optional($imagen)->id;
            $usuarioPerfil->save();
            $usuarioCreado = true;
        }
        return (new PerfilUsuarioResource($usuarioPerfil))->additional([
            'meta' => ['usuario_creado' => $usuarioCreado],
        ]);
    }

    public function enviarCorreo(StorePerfilUsuarioRequest $request, PerfilUsuario $perfilUsuario) {
        ProcesarCorreo::dispatch($perfilUsuario);
    }
}
