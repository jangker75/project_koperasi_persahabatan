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
        $this->call(CmsMenuSeeder::class);
        $this->call(ApplicationSettingSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(CompanyBalanceSeeder::class);
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(InterestSchemeTypeSeeder::class);
        $this->call(ContractTypeSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(DepartmentSeeder::class);
        $this->call(MDStatusSeeder::class);
        $this->call(StoreSeeder::class);
        $this->call(PaymentMethodSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(SupplierSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(ProductCategorySeeder::class);
        $this->call(OrderSeeder::class);
    }
}
