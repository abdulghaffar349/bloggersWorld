<?php

use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        foreach (range(1, 20) as $index) {
            $post = \App\Models\Post::create([
                'title' => $faker->sentence(3),
                'body' => $faker->realText($maxNbChars = 1500),
                'user_id' => App\User::all()->random()->id,
                'created_at' => $faker->dateTimeBetween('-1 years')
            ]);
            $post->tags()->sync([$faker->numberBetween($min = 1, $max = 9), $faker->numberBetween($min = 1, $max = 9)]);
        }
    }
}
