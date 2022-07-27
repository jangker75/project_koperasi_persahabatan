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
            'link' => route('admin.company-balance.index'),
            'icon' => 'fe fe-home',
            'text' => 'Saldo Koperasi',

        ],
        [
            'isseparator' => true,
            'text' => "USiPa"
        ],
        [
            'link' => route('admin.loan-submission.index'),
            'icon' => 'fe fe-home',
            'text' => 'Pengajuan Pinjaman',
        ],
        [
            'link' => route('admin.loan-list.index'),
            'icon' => 'fe fe-home',
            'text' => 'Pinjaman Berjalan',
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
    ];
}
