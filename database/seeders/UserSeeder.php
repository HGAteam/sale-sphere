<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Str;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::create([
            'name' => 'Adrián',
            'lastname'  => 'Tula',
            'slug' => Str::slug('Adrián Tula'),
            'role' => 'Admin',
            'email' => 'webmaster@hgateam.com',
            'password' => Hash::make('Admin#34067!'),
        ]);

        \App\Models\User::create([
            'name' => 'Jorge Luis',
            'lastname'  => 'Frias',
            'slug' => Str::slug('Jorge Luis Frias'),
            'role' => 'Owner',
            'email' => 'jorge@hgateam.com',
            'password' => Hash::make('password'),
        ]);

        \App\Models\User::create([
            'name' => 'Sebastian',
            'lastname'  => 'Ignes',
            'slug' => Str::slug('Sebastian Ignes'),
            'role' => 'Cashier',
            'email' => 'sebastian.ignes@hgateam.com',
            'password' => Hash::make('password'),
        ]);
    }
}
