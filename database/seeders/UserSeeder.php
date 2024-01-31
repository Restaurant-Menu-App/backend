<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::firstOrCreate([
            'slug' => 'developer',
            'name' => 'Developer',
        ]);

        $role->users()->create([
            'name' => 'Admin',
            'email' => 'hlaingwinphyoedev@gmail.com',
            'email_verified_at' => now(),
            'phone' => '09977029311',
            'password' => Hash::make('admin@112233'),
        ]);

        $role = Role::firstOrCreate([
            'slug' => 'admin',
            'name' => 'Admin',
        ]);

        $role = Role::firstOrCreate([
            'slug' => 'operator',
            'name' => 'Operator',
        ]);

        $role = Role::firstOrCreate([
            'slug' => 'user',
            'name' => 'User',
        ]);

        User::factory()->count(10)->create();
    }
}
