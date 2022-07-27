<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\InterestSchemeType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(CompanySeeder::class);
        $this->call(CompanyBalanceSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(InterestSchemeTypeSeeder::class);
        $this->call(ContractTypeSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(MDStatusSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ProductSeeder::class);
    }
}
