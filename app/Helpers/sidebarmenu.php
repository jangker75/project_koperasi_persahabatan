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
            'link' => url('admin/pinjaman'),
            'icon' => 'fe fe-home',
            'text' => 'Menu Pinjaman',

        ],
        [
            'multimenu' => true,
            'icon' => 'fe fe-home',
            'text' => 'multi Menu',
            'submenus' => [
                [
                    'link' => url('admin/pinjaman'),
                    'text' => 'Menu Pinjaman',
                ]
            ]
        ]
    ];
}
