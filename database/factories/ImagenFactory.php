<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\imagen>
 */
class ImagenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->randomAscii();
        $extension = fake()->fileExtension();
        $mime = fake()->mimeType(); // TODO relacionar extension y tipo mime
        return [
            'nombre' => $name . '.' . $extension,
            'extension' => $extension,
            'mime' => $mime,
        ];
    }
}
