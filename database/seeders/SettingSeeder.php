<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Setting::create([
            'business_name' => 'Pamela',
            'owner_name' => 'Jorge Luis Frias',
            'email' => 'jorge@domain.com',
            'cuit' => '',
            'logo' => '',
            'central_location' => '',
            'location_code' => '',
            'phone' => '',
            'mobile' => '+5493813613214',
       ]);
    }
}
