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
            'mobile' => '+5493813201216',
            'address' => 'Alsina 1358',
            'location' => 'San Miguel de Tucuman, Tucumán, Argentina',
        ]);

        \App\Models\User::create([
            'name' => 'Jorge Luis',
            'lastname'  => 'Frias',
            'slug' => Str::slug('Jorge Luis Frias'),
            'role' => 'Owner',
            'email' => 'jorge@hgateam.com',
            'password' => Hash::make('password'),
            'mobile' => '+5493813613214',
            'address' => 'Alsina',
            'location' => 'San Miguel de Tucuman, Tucumán, Argentina',
        ]);

        \App\Models\User::create([
            'name' => 'Sebastian',
            'lastname'  => 'Ignes',
            'slug' => Str::slug('Sebastian Ignes'),
            'role' => 'Cashier',
            'email' => 'sebastian.ignes@hgateam.com',
            'password' => Hash::make('password'),
            'mobile' => '+5493813308207',
            'address' => 'Alsina',
            'location' => 'San Miguel de Tucuman, Tucumán, Argentina',
        ]);
    }
}
