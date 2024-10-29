<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Zone;
use App\Models\Area;

class ZoneSeeder extends Seeder
{
    public function run()
    {
        $zones = [
            [
                'name' => 'United States',
                'areas' => ['California', 'Texas', 'New York', 'Florida', 'Illinois']
            ],
            [
                'name' => 'Canada',
                'areas' => ['Ontario', 'Quebec', 'British Columbia', 'Alberta', 'Manitoba']
            ],
            [
                'name' => 'Australia',
                'areas' => ['New South Wales', 'Victoria', 'Queensland', 'Western Australia', 'South Australia']
            ],
            [
                'name' => 'India',
                'areas' => ['Maharashtra', 'Karnataka', 'Tamil Nadu', 'West Bengal', 'Uttar Pradesh']
            ],
            [
                'name' => 'Germany',
                'areas' => ['Bavaria', 'Berlin', 'Hamburg', 'Hesse', 'Saxony']
            ],
            [
                'name' => 'Brazil',
                'areas' => ['São Paulo', 'Rio de Janeiro', 'Bahia', 'Minas Gerais', 'Paraná']
            ],
            [
                'name' => 'China',
                'areas' => ['Guangdong', 'Beijing', 'Shanghai', 'Zhejiang', 'Jiangsu']
            ],
            [
                'name' => 'South Africa',
                'areas' => ['Gauteng', 'Western Cape', 'KwaZulu-Natal', 'Eastern Cape', 'Mpumalanga']
            ],
            [
                'name' => 'Japan',
                'areas' => ['Tokyo', 'Osaka', 'Kyoto', 'Hokkaido', 'Fukuoka']
            ],
            [
                'name' => 'Mexico',
                'areas' => ['Mexico City', 'Jalisco', 'Nuevo León', 'Puebla', 'Guanajuato']
            ]
        ];

        foreach ($zones as $zoneItem) {
            $zone = Zone::create([Zone::NAME => $zoneItem[Zone::NAME]]);
            
            foreach ($zoneItem['areas'] as $area) {
                Area::create([
                    'name' => $area,
                    'zone_id' => $zone->id
                ]);
            }
        }
    }
}

