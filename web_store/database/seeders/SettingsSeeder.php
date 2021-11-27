<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings_data = [
            'app_name' => "Store name",
            'app_phone' => "01202884899",
            'address' => "somewhere",
        ];
        $settings = Settings::create($settings_data);
    }
}
