<?php

use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['love', 'fashion', 'travel', 'nature', 'inspiration', 'marketing', 'photography', 'lifestyle', 'motivation'];
        foreach ($tags as $tag) {
            \App\Models\Tag::firstOrCreate([
                'name' => $tag
            ]);
        }
    }
}
