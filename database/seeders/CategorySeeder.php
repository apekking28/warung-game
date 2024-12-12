<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Action',
                'description' => 'Fast-paced games focusing on combat, quick reflexes, and movement',
                'image' => 'categories/action.jpg'
            ],
            [
                'name' => 'Adventure',
                'description' => 'Story-driven games with exploration and puzzle-solving elements',
                'image' => 'categories/adventure.jpg'
            ],
            [
                'name' => 'RPG',
                'description' => 'Games featuring character development, rich storytelling, and strategic combat',
                'image' => 'categories/rpg.jpg'
            ],
            [
                'name' => 'Strategy',
                'description' => 'Games that emphasize tactical thinking and careful planning',
                'image' => 'categories/strategy.jpg'
            ],
            [
                'name' => 'Sports',
                'description' => 'Virtual simulations of traditional athletic competitions',
                'image' => 'categories/sports.jpg'
            ],
            [
                'name' => 'Racing',
                'description' => 'High-speed competitive driving games with various vehicles',
                'image' => 'categories/racing.jpg'
            ],
            [
                'name' => 'Simulation',
                'description' => 'Realistic games that simulate real-world activities and scenarios',
                'image' => 'categories/simulation.jpg'
            ],
            [
                'name' => 'Puzzle',
                'description' => 'Games focused on problem-solving and logical thinking',
                'image' => 'categories/puzzle.jpg'
            ],
            [
                'name' => 'Horror',
                'description' => 'Suspenseful games designed to create fear and tension',
                'image' => 'categories/horror.jpg'
            ],
            [
                'name' => 'Fighting',
                'description' => 'Combat-focused games featuring one-on-one or team-based battles',
                'image' => 'categories/fighting.jpg'
            ]
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'image' => $category['image'],
                'description' => $category['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'created_by' => 1, // Assuming admin user has ID 1
                'updated_by' => 1
            ]);
        }
    }
}
