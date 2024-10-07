<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Partner;
use File;


class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Partner::truncate();
  
        $json = File::get("database/data/partners.json");
        $data = json_decode($json);
  
        foreach ($data as $key => $value) {
            Partner::create([
                "name" => $value->name,
                "logo" => $value->logo
            ]);
        }
    }
}
