<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;
use File;


class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::truncate();
  
        $json = File::get("database/data/setting.json");
        $data = json_decode($json);
  
        foreach ($data as $key => $value) {
            Setting::create([
                "key" => $value->key,
                "value" => $value->value
            ]);
        }
    }
}
