<?php
function listSideMenu()
{
    return [
        [
            'isseparator' => true,
            'text' => "MAIN"
        ],
        [
            'link' => url('admin/dashboard'),
            'icon' => 'fe fe-home',
            'text' => 'Menu Dashboard',

        ],
        [
            'isseparator' => true,
            'text' => "Kelola Toko"
        ],
        [
            'link' => "#",
            'icon' => 'fe fe-dollar-sign',
            'text' => 'Data Penjualan',

        ],
        [
            'multimenu' => true,
            'icon' => 'fe fe-shopping-cart',
            'text' => 'Kelola Data Toko',
            'submenus' => [
                [
                    'link' => url('/admin/product'),
                    'text' => 'Kelola Data Produk',
                ],
                [
                    'link' => url('/admin/category'),
                    'text' => 'Kelola Data Kategori Produk',
                ],
                [
                    'link' => url('/admin/brand'),
                    'text' => 'Kelola Data Brand',
                ],
                [
                    'link' => url('/admin/supplier'),
                    'text' => 'Kelola Data Pemasok',
                ]
            ]
        ],
        [
            'multimenu' => true,
            'icon' => 'fe fe-database',
            'text' => 'Pengadaan',
            'submenus' => [
                [
                    'link' => '#',
                    'text' => 'Management Stok Barang',
                ],
                [
                    'link' => '#',
                    'text' => 'Transfer Stok',
                ],
                [
                    'link' => '#',
                    'text' => 'Audit Opname',
                ],
            ]
        ],
        [
            'multimenu' => true,
            'icon' => 'fa fa-money',
            'text' => 'Paylater',
            'submenus' => [
                [
                    'link' => '#',
                    'text' => 'Pengajuan Paylater',
                ],
                [
                    'link' => '#',
                    'text' => 'Kelola Data Paylater',
                ],
            ]
        ],
        [
            'link' => url("admin/store"),
            'icon' => 'fe fe-map-pin',
            'text' => 'Data Toko',
        ],
        [
            'isseparator' => true,
            'text' => "USiPa"
        ],
        [
            'multimenu' => true,
            'icon' => 'fe fe-credit-card',
            'text' => 'Menu Pinjaman',
            'submenus' => [
                [
                    'link' => route('admin.loan-submission.index'),
                    'text' => 'Pengajuan Pinjaman',
                ],
                [
                    'link' => route('admin.loan-list.index'),
                    'text' => 'Data Pinjaman',
                ]
            ]
        ],
        [
            'isseparator' => true,
            'text' => "Divisi Umum"
        ],
        [
            'link' => route('admin.employee.index'),
            'icon' => 'fe fe-users',
            'text' => 'Data Anggota',
        ],
        [
            'link' => route('admin.ex-employee.index'),
            'icon' => 'fe fe-users',
            'text' => 'Data Anggota Keluar',
        ],
        [
            'isseparator' => true,
            'text' => "MASTER DATA"
        ],
        [
            'link' => url('admin/master-data-status'),
            'icon' => 'fe fe-layers',
            'text' => 'Master Data Status',
        ],
        [
            'isseparator' => true,
            'text' => "Setting Application"
        ],
        [
            'link' => url('admin/switcher'),
            'icon' => 'mdi mdi-wrench',
            'text' => 'Switcher',

        ]
    ];
}
