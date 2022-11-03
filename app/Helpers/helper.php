<?php

use App\Models\ApplicationSetting;
use App\Models\Company;
use App\Models\Promo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

if (!function_exists('format_bulan')) {
    function format_bulan($waktu){
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
        return "$bulan";
    }
}
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
if (!function_exists('format_tanggal_tahun')) {
    function format_tanggal_tahun($waktu)
    {
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

        //untuk menampilkan hari, tanggal bulan tahun
        return "$bulan $tahun";
    }
}
if (!function_exists('getCompanyData')) {
    function getCompanyId()
    {
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

if (!function_exists('format_tanggal_bulan_tahun')) {
    function format_tanggal_bulan_tahun($waktu)
    {
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
        return "$tanggal $bulan $tahun";
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
        $formatted = $dateCarbon->isoFormat('D MMMM Y');
        return $formatted;
    }
}
if (!function_exists('getUserRole')) {
    function getUserRole($userId = null)
    {
        if($userId != null){
            $user = User::find($userId);
            $role = $user->getRoleNames()[0];
            return $role;
        }
        else if(auth()->check()){
            $role = auth()->user()->getRoleNames()[0];
            return $role;
        }
        return null;
    }
}

if (!function_exists('checkPositionRole')) {
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
            case 'UMM':
                $role = 'umum';
                break;
            default:
                $role = 'superadmin';
                break;
        }
        return $role;
    }
}

if (!function_exists('getAppSettingContent')) {
    function getAppSettingContent($nameSetting)
    {
        $data = ApplicationSetting::where('name', $nameSetting)->first();
        return $data->content;
    }
}

if(!function_exists('getTableColumn')){
    function getTableColumn($table){
        return Schema::getColumnListing($table);
    }
}
if(!function_exists('terbilang')){
    function terbilang($angka) {
        $angka=abs($angka);
        $baca =array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
      
        $terbilang="";
         if ($angka < 12){
             $terbilang= " " . $baca[$angka];
         }
         else if ($angka < 20){
             $terbilang= terbilang($angka - 10) . " Belas";
         }
         else if ($angka < 100){
             $terbilang= terbilang($angka / 10) . " Puluh" . terbilang($angka % 10);
         }
         else if ($angka < 200){
             $terbilang= " Seratus" . terbilang($angka - 100);
         }
         else if ($angka < 1000){
             $terbilang= terbilang($angka / 100) . " Ratus" . terbilang($angka % 100);
         }
         else if ($angka < 2000){
             $terbilang= " Seribu" . terbilang($angka - 1000);
         }
         else if ($angka < 1000000){
             $terbilang= terbilang($angka / 1000) . " Ribu" . terbilang($angka % 1000);
         }
         else if ($angka < 1000000000){
            $terbilang= terbilang($angka / 1000000) . " Juta" . terbilang($angka % 1000000);
         }
            return $terbilang;
     }
}

if(!function_exists('convertNumberToStringExcel')) {
    function convertNumberToStringExcel($number){
        return '="' . $number . '"';
    }
}