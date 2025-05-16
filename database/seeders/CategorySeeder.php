<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'Civil Case',
            'description' => 'Files related to civil case matters'
        ]);

        Category::create([
            'name' => 'Admin Case',
            'description' => 'Files related to administrative cases'
        ]);

        Category::create([
            'name' => 'Government Survey',
            'description' => 'Files related to government surveys'
        ]);

        Category::create([
            'name' => 'Inspection Report',
            'description' => 'Reports and documents related to inspections'
        ]);

        Category::create([
            'name' => 'Request from Survey',
            'description' => 'Requests and documents from surveys'
        ]);
    }
}
