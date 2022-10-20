<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        /* *{
            outline: 1px solid red;
        } */
        .page_break {
            page-break-before: always;
        }

        .logo-koperasi {
            position: absolute;
            top: 0%;
            left: 0%;
        }
        .logo-rs {
            position: absolute;
            top: 0%;
            right: 0%;
        }
        .section-information{
            margin-bottom: 40px;
        }
        table.table-simulasi {
            /* border: 1px solid black; */
            border-collapse: collapse;
        }
        table.table-simulasi th{
            padding-top: 7px;
            padding-bottom: 7px;
            border: 2px solid black;
        }
        table.table-simulasi td{
            padding: 5px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="logo-koperasi">
        <img src="{{ asset('assets/images/logo/logo3.png') }}" width="100px" height="100px" alt="">
    </div>
    <div class="logo-rs">
        <img src="{{ asset('assets/images/logo/logo.png') }}" width="100px" height="100px" alt="">
    </div>
    <section class="kop-surat">
        <div>
            <p style="text-align: center;">
                <b>KOPERASI KARYA HUSADA</b><br>
                Rumah Sakit Umum Pusat Persahabatan
            </p>
            <p style="margin-top: 50px; text-align: center; font-weight: 700; font-size: 32px">
                Pinjaman Anggota
            </p>
        </div>
    </section>
    <section class="section-information">
        <table style="width: 100%">
            <tr>
                <td style="width: 45%">
                    <table style="width: 100%" class="table-information-left">
                        <tr>
                            <td>NPK</td>
                            <td>:</td>
                            <td>______________</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>:</td>
                            <td>______________</td>
                        </tr>
                        <tr>
                            <td>Jenis Kontrak</td>
                            <td>:</td>
                            <td>______________</td>
                        </tr>
                        <tr>
                            <td>Bunga</td>
                            <td>:</td>
                            <td>______________</td>
                        </tr>
                        <tr>
                            <td>Jumlah Diterima</td>
                            <td>:</td>
                            <td>______________</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 45%">
                    <table style="width: 100%" class="table-information-right">
                        <tr>
                            <td>Tanggal</td>
                            <td>:</td>
                            <td>{{ now()->format("d/m/Y") }}</td>
                        </tr>
                        <tr>
                            <td>Total Pinjaman</td>
                            <td>:</td>
                            <td>{{ format_uang(str_replace(".","",$data[0]['saldo_hutang'])) }}</td>
                        </tr>
                        <tr>
                            <td>Biaya ADM</td>
                            <td>:</td>
                            <td>______________</td>
                        </tr>
                        <tr>
                            <td>Margin</td>
                            <td>:</td>
                            <td>______________</td>
                        </tr>
                        <tr>
                            <td>Tabungan</td>
                            <td>:</td>
                            <td>______________</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </section>
    <section class="section-table">
        <table class="table-simulasi" style="width: 100%;">
            <thead>
                <tr>
                    <th>Cicilan-ke #</th>
                    <th>Tgl Tagih</th>
                    <th>Sisa Pokok</th>
                    <th>Pokok</th>
                    <th>Margin KOP</th>
                    <th>Simpanan Khusus</th>
                    <th>Total Cicilan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $item)
                    <tr>
                        <td>{{ $item['cicilan_ke'] }}</td>
                        <td>{{ $item['tgl_tagih'] }}</td>
                        <td>{{ $item['saldo_hutang'] }}</td>
                        <td>{{ $item['pokok'] }}</td>
                        <td>{{ $item['margin_kop'] }}</td>
                        <td>{{ $item['margin_employee'] }}</td>
                        <td>{{ $item['total_cicilan'] }}</td>
                    </tr>
                @endforeach
                    <tr>
                        <td colspan="5"><b>Total</b></td>
                        <td>{{ format_uang(str_replace(".","",$lastrow["total_bunga"])) }}</td>
                        <td>{{ format_uang(str_replace(".","",$lastrow["total_cicilan"])) }}</td>
                    </tr>
            </tbody>
        </table>
    </section>
</body>
</html>