<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('crear una imagen', function () {
    Storage::fake('s3');

    $response = $this->json('POST', '/url-generator/imagen', [
        'imagen' => UploadedFile::fake()->image('foobar.jpg'),
    ]);

    Storage::disk('s3')->assertExists('imagenes/foobar.jpg');

    $this->assertDatabaseHas('imagenes', [
        'nombre' => 'foobar.jpg',
    ]);
});
