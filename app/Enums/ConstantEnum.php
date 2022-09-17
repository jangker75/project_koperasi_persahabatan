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
    const INTEREST_AMOUNT_TYPE = [
        'percentage' => 'Percentage',
        'value' => 'Value',
    ];
    const TRANSACTION_TYPE = [
        'debit' => 'Debit',
        'credit' => 'Credit',
    ];
    const BALANCE_COMPANY = [
        'loan_balance' => 'Saldo Pinjaman',
        'store_balance' => 'Saldo Toko',
        'other_balance' => "Saldo Utama Koperasi",
    ];
    const SAVINGS_BALANCE_TYPE = [
        'POKOK' => 'principal_savings_balance',
        'WAJIB' => 'mandatory_savings_balance',
        'AKTIVITAS' => 'activity_savings_balance',
        'SUKARELA' => 'voluntary_savings_balance',
    ];
    const ORDER_BY = [
      "pos" => "POS",
      "nasabah" => "NASABAH"
    ];
}
