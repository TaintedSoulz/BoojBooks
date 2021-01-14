<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Book::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'olid'          => $this->faker->unique()->uuid,
            'url'           => $this->faker->url,
            'title'         => $this->faker->title,
            'author'        => $this->faker->name,
            'author_url'    => $this->faker->url,
            'publish_date'    => $this->faker->date('M Y'),
            'cover_small'    => $this->faker->imageUrl()
        ];
    }
}
