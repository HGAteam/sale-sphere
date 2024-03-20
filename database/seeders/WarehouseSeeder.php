<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\Warehouse::create([
            'name' => 'Pamela Online',
            'slug' => 'pamela-online',
            'location' => 'No Aplica',
            'address' => 'No Aplica',
            'status' => 1,
            'branch_manager' => 'Jorge Luis Frias',
            'phone' => '--',
            'mobile' => '+5493813613214',
            'details' => 'Cambiar los datos que se vean necesarios.',
        ]);

        \App\Models\Warehouse::create([
            'name' => 'Pamela 1',
            'slug' => 'pamela-1',
            'location' => 'Bracho',
            'address' => 'alguna direción',
            'status' => 1,
            'branch_manager' => 'Jorge Luis Frias',
            'phone' => '--',
            'mobile' => '+5493813613214',
            'details' => 'Cambiar los datos que se vean necesarios.',
        ]);

        \App\Models\Warehouse::create([
            'name' => 'Pamela 2',
            'slug' => 'pamela-2',
            'location' => 'San Miguel de Tucumán',
            'address' => 'Alsina 1353',
            'status' => 1,
            'branch_manager' => 'Jorge Luis Frias',
            'phone' => '--',
            'mobile' => '+5493813613214',
            'details' => 'Cambiar los datos que se vean necesarios.',
        ]);

    }
}
