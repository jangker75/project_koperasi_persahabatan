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
            'text' => 'Data Karyawan',

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
    ];
}
