<?php

namespace Database\Seeders;

use App\Models\InterestSchemeType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestSchemeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $scheme = [
            [
                'name' => 'Flat',
            ],
            [
                'name' => 'Menurun',
            ],
        ];

        collect($scheme)->each(function($item){
            InterestSchemeType::create($item);
        });
    }
}
