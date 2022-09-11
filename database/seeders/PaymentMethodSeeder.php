<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
          ["name" => "cash"],
          ["name" => "gopay"],
          ["name" => "ovo"],
          ["name" => "paylater"]
        ])->each(function($data){
          PaymentMethod::create($data);
        });
    }
}
