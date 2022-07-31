<?php

namespace Database\Seeders;

use App\Models\ApplicationSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApplicationSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'app_name',
                'label' => 'Application Name',
                'content' => 'Aplikasi Kokarda',
                'description' => 'Name Of application',
                'type' => 'text',
            ],
            [
                'name' => 'tax',
                'label' => 'Tax',
                'content' => 0,
                'description' => 'Tax Application',
                'type' => 'number',
            ],
            [
                'name' => 'web_url',
                'label' => 'Website URL',
                'content' => 'https://kokardarspersahabatan.com',
                'description' => 'Website Company',
                'type' => 'text',
            ],
            [
                'name' => 'company',
                'label' => 'Company Name',
                'content' => 'Koperasi Karya Husada',
                'description' => '',
                'type' => 'text',
            ],
            [
                'name' => 'address',
                'label' => 'Address Company',
                'content' => '',
                'description' => 'Address Company',
                'type' => 'textarea',
            ],
            [
                'name' => 'phone',
                'label' => 'Phone Number',
                'content' => '+6288806383073',
                'description' => 'Phone Number Company',
                'type' => 'text',
            ],
        ];
        collect($data)->each(function($item){
            ApplicationSetting::create($item);
        });
    }
}
