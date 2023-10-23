<?php

namespace App\Http\Controllers;

use App\Models\imagen;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;

class DynamicPage extends Controller
{
    /**
     * Crear imagen
     */
    public function crearImagen(Request $request): string
    {
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $name = $file->hashName();
            $extension = $file->extension();
            $mime = $file->getMimeType();

            $path = $file->storePubliclyAs(
                'imagenes',
                $name,
                's3'
            );

            if (!$path) {
                throw new Exception('No se pudo generar la imagen', 400);
            }

            $imagen = new imagen();
            $imagen->nombre = $name;
            $imagen->extension = $extension;
            $imagen->mime = $mime;
            $imagen->save();

            return new JsonResponse([
                'path' => $path,
            ]);
        }
        throw new BadRequestException('Imagen no encontrada', 400);
    }
}
