<?php

namespace App\Enums;

class ConstantEnum
{
    const GENDER = [
        'P' => 'Perempuan',
        'L' => 'Laki-Laki',
    ];
    const BANK = ['mandiri' => 'Mandiri', 'bri' => 'BRI', 'bca' => 'BCA'];
    const RESIGNREASON = [
        'pensiun' => 'Pensiun',
        'mutasi' => 'Mutasi',
        'resign' => 'Mengundurkan Diri',
    ];
}
