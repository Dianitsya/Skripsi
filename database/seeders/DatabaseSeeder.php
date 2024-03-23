<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'=> 'Admin',
            'email'=> 'admin@admin.com',
            'is_admin'=> true,
        ]);
        User::factory()->create([
            'name'=> 'Dianitasya Ananda Masta',
            'email'=> 'dianitasyanandamasta@gmail.com',
            'is_admin'=> true,
        ]);

       User::factory(100)->create();
       Todo::factory(500)->create();
    }
}
