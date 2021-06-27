<?php

namespace Database\Factories;

use App\Models\Bookable;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;


class BookableFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookable::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */

    

    public function definition()
    {
        $suffix = [
            'Villa',
            'House',
            'Cottage',
            'Luxury Villas',
            'Cheap House',
            'Rooms',
            'Cheap Rooms',
            'Luxury Rooms',
            'Fancy Rooms',
        ];
        return [
            'created_at' => now(),
            'title' => $this->faker->city.' '.$suffix[array_rand($suffix)],
            'description' => $this->faker->text(),
            'price' => random_int(50, 1000),
        ];
    }
}
