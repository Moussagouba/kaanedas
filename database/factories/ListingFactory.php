<?php

namespace Database\Factories;


use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(rand(2, 7));
        $datetime = $this->faker->dateTimeBetween(startDate: '-1 month', endDate: 'now');
        $content = '';
        for ($i = 0; $i < 5; $i++) {
            $content = '<p class="mb-4">' . $this->faker->sentence(rand(2, 10)) . '</p>';
        }
        return [

            'title' => $title,
            'slug' =>  Str::slug($title) . '-' . rand(1111,  9999),
            'compagny' => $this->faker->company,
            'location' => $this->faker->country,
            'logo' => basename($this->faker->image(storage_path('app/public'))),
            'tres_recherche' => (rand(1, 9) > 7),
            'est_active' => true,
            'content' => $content,
            'lien' => $this->faker->url,
            'created_at' => $datetime,
            'updated_at' => $datetime,

        ];
    }
}
