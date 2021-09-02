<?php

namespace Database\Factories;

use App\Models\Ebook;
use Illuminate\Database\Eloquent\Factories\Factory;

class EbookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Ebook::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $mockNumber = $this->faker->randomElement(range(0, 30));
        return [
            'title' => $this->faker->sentence(),
            'year' => $this->faker->year(),
            'description' => $this->faker->text(),
            'front_cover_image' => "covers/mock-{$mockNumber}.jpg",
            'pdf_path' => 'ebooks/mock.pdf',
        ];
    }
}
