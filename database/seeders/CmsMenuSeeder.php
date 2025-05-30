<?php

namespace Database\Seeders;

use App\Models\CmsMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CmsMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // MAIN Menu
        CmsMenu::create([
                'isseparator' => true,
                'name' => 'MAIN',
        ]);
        CmsMenu::create([
            
                'name' => 'Saldo Koperasi',
                'url' => 'admin/company-balance', 
                'icon' => 'fe fe-home', 
        ]);

        // POS
        CmsMenu::create([
                'isseparator' => true,
                'name' => 'Point of Sale',
        ]);
        CmsMenu::create([
                'name' => 'Checkout Order',
                'url' => 'admin/pos/checkout', 
                'icon' => 'fe fe-dollar-sign', 
        ]);
        CmsMenu::create([
                'name' => 'Permintaan Order',
                'url' => 'admin/pos/request-order', 
                'icon' => 'fa fa-money', 
        ]);
        CmsMenu::create([
                'name' => 'History Order',
                'url' => 'admin/pos/history-order', 
                'icon' => 'fa fa-shopping-cart', 
        ]);
        CmsMenu::create([
                'name' => 'History Paylater',
                'url' => 'admin/pos/history-paylater', 
                'icon' => 'fa fa-credit-card', 
        ]);
        

        // Kelola Toko Menu
        CmsMenu::create([
                'isseparator' => true,
                'name' => 'KELOLA TOKO',
        ]);
        
        
        $dataToko = CmsMenu::create([
                'name' => 'Kelola Data Toko',
                'url' => 'admin/toko', 
                'icon' => 'fe fe-shopping-cart', 
        ]);

        // Sub Menu kelola toko
        $dataToko->subMenus()->create([
                'name' => 'Kelola Data Product',
                'url' => 'admin/toko/product', 
        ]);
        $dataToko->subMenus()->create([
                'name' => 'Kelola Data Kategori Product',
                'url' => 'admin/toko/category', 
        ]);
        $dataToko->subMenus()->create([
                'name' => 'Kelola Data Brand',
                'url' => 'admin/toko/brand', 
        ]);
        $dataToko->subMenus()->create([
                'name' => 'Kelola Data Pemasok',
                'url' => 'admin/toko/supplier', 
        ]);
        $dataToko->subMenus()->create([
                'name' => 'Data Toko',
                'url' => 'admin/toko/store', 
        ]);
        $dataToko->subMenus()->create([
                'name' => 'Data Metode Pembayaran',
                'url' => 'admin/toko/payment-method', 
        ]);
        // CmsMenu::create([
        //         'name' => 'Data Toko',
        //         'url' => 'admin/store', 
        //         'icon' => 'fe fe-map-pin', 
        // ]);
        //END Sub Menu kelola toko

        $dataPengadaan = CmsMenu::create([
                'name' => 'Stok Barang',
                'url' => 'admin/pengadaan', 
                'icon' => 'fe fe-database', 
        ]);
        // Sub Menu Pengadaan
        $dataPengadaan->subMenus()->create([
                'name' => 'Manajemen Stok barang',
                'url' => 'admin/toko/management-stock', 
        ]);
        $dataPengadaan->subMenus()->create([
                'name' => 'Order Supplier',
                'url' => 'admin/toko/order-supplier', 
        ]);
        $dataPengadaan->subMenus()->create([
                'name' => 'Audit Opname',
                'url' => 'admin/toko/opname', 
        ]);
        $dataPengadaan->subMenus()->create([
                'name' => 'Return Barang',
                'url' => 'admin/toko/return-supplier', 
        ]);
        //END Sub Menu Pengadaan

        // $dataPaylater = CmsMenu::create([
        //         'name' => 'Paylater',
        //         'url' => 'admin/paylater', 
        //         'icon' => 'fa fa-money', 
        // ]);
        // // Sub Menu Paylater
        // $dataPaylater->subMenus()->create([
        //         'name' => 'Pengajuan Paylater',
        //         'url' => 'admin/paylater/pengajuan-paylater', 
        // ]);
        // $dataPaylater->subMenus()->create([
        //         'name' => 'Kelola Data Paylater',
        //         'url' => 'admin/paylater/kelola-data-paylater', 
        // ]);
        //END Sub Menu Paylater

        

        // Usipa
        CmsMenu::create([
                'isseparator' => true,
                'name' => 'USIPA',
        ]);
        CmsMenu::create([
                'name' => 'Pengajuan Pinjaman',
                'url' => 'admin/loan-submission', 
                'icon' => 'fe fe-home', 
        ]);
        CmsMenu::create([
                'name' => 'Pinjaman Berjalan',
                'url' => 'admin/loan-list', 
                'icon' => 'fe fe-home', 
        ]);

        // Divisi Umum
        CmsMenu::create([
                'isseparator' => true,
                'name' => 'DIVISI UMUM',
        ]);
        CmsMenu::create([
                'name' => 'Data Anggota',
                'url' => 'admin/employee', 
                'icon' => 'fe fe-users', 
        ]);
        CmsMenu::create([
                'name' => 'Data Anggota Keluar',
                'url' => 'admin/ex-employee', 
                'icon' => 'fe fe-users', 
        ]);
        CmsMenu::create([
                'name' => 'Catat Kas Keluar/Masuk',
                'url' => 'admin/cash-in-out', 
                'icon' => 'fa fa-money', 
        ]);

        // Divisi Umum
        // CmsMenu::create([
        //         'isseparator' => true,
        //         'name' => 'MASTER DATA',
        // ]);
        // CmsMenu::create([
        //         'name' => 'Master Data Status',
        //         'url' => 'admin/master-data-status', 
        //         'icon' => 'fe fe-layers', 
        // ]);

        // SETTING APPLICATION
        CmsMenu::create([
                'isseparator' => true,
                'name' => 'SETTING APPLICATION',
        ]);
        CmsMenu::create([
                'name' => 'Switcher',
                'url' => 'admin/switcher', 
                'icon' => 'mdi mdi-wrench', 
        ]);
        CmsMenu::create([
                'name' => 'Application Setting',
                'url' => 'admin/app-setting', 
                'icon' => 'mdi mdi-wrench', 
        ]);
        CmsMenu::create([
                'name' => 'Role Management',
                'url' => 'admin/role-management', 
                'icon' => 'mdi mdi-wrench', 
        ]);


    }
}
