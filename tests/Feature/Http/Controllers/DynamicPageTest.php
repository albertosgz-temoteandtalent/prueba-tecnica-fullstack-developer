<?php

use App\Models\imagen;
use App\Models\PerfilUsuario;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('crear una imagen', function () {
    Storage::fake('s3');

    $response = $this->json('POST', '/api/url-generator/imagen', [
        'imagen' => UploadedFile::fake()->image('foobar.jpg'),
    ]);

    $urlImagen = $response->getContent();
    $nombre = last(explode('/', $urlImagen));

    Storage::disk('s3')->assertExists('imagenes/' . $nombre);

    $this->assertDatabaseHas('imagenes', [
        'nombre' => $nombre,
    ]);
});

it('crear usuario (sin imagen)', function () {

    $usuario = PerfilUsuario::factory()->make();

    $this->json('POST', '/api/url-generator/usuario', [
        'nombre' => $usuario->nombre,
        'apellidos' => $usuario->apellidos,
        'telefono' => $usuario->telefono,
        'correo' => $usuario->correo,
    ])
        ->assertStatus(201)
        ->assertJson([
        'meta' => [ 'usuario_creado' => true],
    ]);
});

it('no se puede crear usuario repetido (sin imagen)', function () {

    $usuario = PerfilUsuario::factory()->create();

    $this->json('POST', '/api/url-generator/usuario', [
        'nombre' => $usuario->nombre,
        'apellidos' => $usuario->apellidos,
        'telefono' => $usuario->telefono,
        'correo' => $usuario->correo,
    ])
        ->assertStatus(200)
        ->assertJson([
        'meta' => [ 'usuario_creado' => false],
    ]);
});

it('se puede crear usuario con campo diferente (sin imagen)', function () {

    $usuario = PerfilUsuario::factory()->create();

    $this->json('POST', '/api/url-generator/usuario', [
        'nombre' => $usuario->nombre . 'foobar',
        'apellidos' => $usuario->apellidos,
        'telefono' => $usuario->telefono,
        'correo' => $usuario->correo,
    ])
        ->assertStatus(201)
        ->assertJson([
            'meta' => [ 'usuario_creado' => true],
        ]);
});

it('crear usuario con imagen', function () {
    Storage::fake('s3');

    $imagen = imagen::factory()->create();
    $usuario = PerfilUsuario::factory()->make();

    $this->json('POST', '/api/url-generator/usuario', [
        'nombre' => $usuario->nombre,
        'apellidos' => $usuario->apellidos,
        'telefono' => $usuario->telefono,
        'correo' => $usuario->correo,
        'imagen' => $imagen->nombre,
    ])
        ->assertStatus(201)
        ->assertJson([
            'meta' => [ 'usuario_creado' => true],
        ]);
});

it('no se puede crear usuario repetido', function () {
    Storage::fake('s3');

    $imagen = imagen::factory()->create();
    $usuario = PerfilUsuario::factory()->create([
        'imagen_id' => $imagen->id,
    ]);

    $this->json('POST', '/api/url-generator/usuario', [
        'nombre' => $usuario->nombre,
        'apellidos' => $usuario->apellidos,
        'telefono' => $usuario->telefono,
        'correo' => $usuario->correo,
        'imagen' => '/storage/imagenes/' . $imagen->nombre,
    ])
        ->assertStatus(200)
        ->assertJson([
            'meta' => [ 'usuario_creado' => false],
        ]);
});

it('no se puede crear usuario con todos los campos vacios', function () {
    $this->json('POST', '/api/url-generator/usuario', [
    ])
        ->assertStatus(400);
});

it('enviar correo', function () {
    Queue::fake();

    $usuario = PerfilUsuario::factory()->create();

    $this->json('POST', '/api/url-generator/usuario/' . $usuario->id . '/enviar-correo', [])
        ->assertStatus(200);

    Queue::assertPushed(\App\Jobs\ProcesarCorreo::class);
});
