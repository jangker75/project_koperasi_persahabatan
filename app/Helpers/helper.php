<?php

use App\Models\Company;

if (!function_exists('format_hari_tanggal')) {
    function format_hari_tanggal($waktu)
    {
        $hari_array = array(
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        );
        $hr = date('w', strtotime($waktu));
        $hari = $hari_array[$hr];
        $tanggal = date('j', strtotime($waktu));
        $bulan_array = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        );
        $bl = date('n', strtotime($waktu));
        $bulan = $bulan_array[$bl];
        $tahun = date('Y', strtotime($waktu));

        //untuk menampilkan hari, tanggal bulan tahun jam
        //return "$hari, $tanggal $bulan $tahun $jam";

        //untuk menampilkan hari, tanggal bulan tahun
        return "$hari, $tanggal $bulan $tahun";
    }
}
if (!function_exists('getCompanyData')) {
    function getCompanyId(){
        return Company::find(1);
    }
}
if (!function_exists('format_hari_tanggal_jam')) {
    function format_hari_tanggal_jam($waktu)
    {
        $hari_array = array(
            'Minggu',
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        );
        $hr = date('w', strtotime($waktu));
        $hari = $hari_array[$hr];
        $tanggal = date('j', strtotime($waktu));
        $bulan_array = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        );
        $bl = date('n', strtotime($waktu));
        $bulan = $bulan_array[$bl];
        $tahun = date('Y', strtotime($waktu));
        $jam = date('H:i', strtotime($waktu));

        //untuk menampilkan hari, tanggal bulan tahun jam
        //return "$hari, $tanggal $bulan $tahun $jam";

        //untuk menampilkan hari, tanggal bulan tahun
        return "$hari, $tanggal $bulan $tahun $jam";
    }
}

if (!function_exists('format_uang')) {
    function format_uang($angka)
    {
        $hasil =  number_format($angka, 0, ',', '.');
        return 'Rp. ' . $hasil;
    }
}
if (!function_exists('format_uang_no_prefix')) {
    function format_uang_no_prefix($angka)
    {
        $hasil =  number_format($angka, 0, ',', '.');
        return $hasil;
    }
}

if (!function_exists('format_tanggal')) {
    function format_tanggal($date)
    {
        $dateCarbon = \Carbon\Carbon::parse($date);
        $formatted = $dateCarbon->isoFormat('dddd, D MMMM Y');
        return $formatted;
    }
}
if (!function_exists('getUserRole')) {
    function getUserRole()
    {
        if (auth()->check()) {
            $role = auth()->user()->getRoleNames()[0];
            // $role = auth()->user()->role;
            return $role;
        }
        return null;
    }
}

if(!function_exists('checkPositionRole')){
    function checkPositionRole($position_code)
    {
        switch ($position_code) {
            case 'USP':
                $role = 'usipa';
                break;
            case 'TKO':
                $role = 'toko';
                break;
            case 'KSR':
                $role = 'kasir';
                break;
            case 'NSB':
                $role = 'nasabah';
                break;
            case 'MGR':
                $role = 'manager';
                break;
            default:
                $role = 'superadmin';
                break;
        }
        return $role;
    }
}