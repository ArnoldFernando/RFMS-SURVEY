<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\File;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $statuses = ['for_action', 'action_completed', 'archived'];
        $categories = Category::all();
        $users = User::all();

        foreach (range(1, 500) as $index) {
            File::create([
                'file_name' => 'File ' . $index,
                'location' => 'Location ' . $index,
                'description' => 'Description for file ' . $index,
                'file' => 'example-file-' . $index . '.pdf',
                'civil_case_number' => 'CCN-' . Str::random(5),
                'lot_number' => 'LOT-' . Str::random(3),
                'status' => $statuses[array_rand($statuses)],
                'category_id' => $categories->random()->id,
                'user_id' => $users->random()->id,
                'created_at' => now()->setYear(2025)->setMonth(rand(1, 12))->setDay(rand(1, 28)),
                'updated_at' => now()->setYear(2025)->setMonth(rand(1, 12))->setDay(rand(1, 28)),
            ]);
        }
    }
}
