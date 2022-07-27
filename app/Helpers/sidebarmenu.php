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
            'text' => 'Produk',
            'submenus' => [
                [
                    'link' => url('/admin/product'),
                    'text' => 'Kelola Data Produk',
                ],
                [
                    'link' => '#',
                    'text' => 'Kelola Data Stock',
                ],
                [
                    'link' => '#',
                    'text' => 'Kelola Data Brand',
                ],
                [
                    'link' => '#',
                    'text' => 'Kelola Data Pemasok',
                ],
                [
                    'link' => url('/admin/category'),
                    'text' => 'Kelola Data Kategori Produk',
                ]
            ]
        ],
        [
            'isseparator' => true,
            'text' => "USiPa"
        ],
        [
            'multimenu' => true,
            'icon' => 'fe fe-home',
            'text' => 'Menu Pinjaman',
            'submenus' => [
                [
                    'link' => '#',
                    'text' => 'Pengajuan Pinjaman',
                ],
                [
                    'link' => '#',
                    'text' => 'Approve Pinjaman',
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
            'text' => "Setting Application"
        ],
        [
            'link' => url('admin/switcher'),
            'icon' => 'mdi mdi-wrench',
            'text' => 'Switcher',

        ],
        [
            'isseparator' => true,
            'text' => "MASTER DATA"
        ],
        [
            'link' => url('admin/master-data-status'),
            'icon' => 'fe fe-layers',
            'text' => 'Master Data Status',
        ]
    ];
}
