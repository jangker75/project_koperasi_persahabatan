<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
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
        .date-surat{
            margin-left: 20px;
        }
        table#table-date tr td{
            padding-left: 10px;
            padding-right: 10px;
            border: none !important;
        }
        table#table-content, tr ,td, th{
            border: 1px solid black;
            padding: 5px;
            border-collapse: collapse;
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
                Laporan Kas
            </p>
        </div>
    </section>
    <section class="date-surat">
        <div>
            <table id="table-date">
                <tr>
                    <td>TANGGAL</td>
                    <td>{{ \Carbon\Carbon::parse($date_from)->format('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>SAMPAI TANGGAL</td>
                    <td>{{ \Carbon\Carbon::parse($date_to)->format('d-m-Y') }}</td>
                </tr>
            </table>
        </div>
    </section>
    <section>
        <div>
            <table id="table-content" style="width: 100%; ">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>BULAN</th>
                        <th>TANGGAL</th>
                        <th>DESKRIPSI</th>
                        <th style="width: 19%">DEBET</th>
                        <th style="width: 19%">CREDIT</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $report)
                    <tr>
                        <td style="text-align: center">{{ $loop->iteration }}</td>
                        <td>{{ format_bulan($report->transaction_date) }}</td>
                        <td style="text-align: center">{{ \Carbon\Carbon::parse($report->transaction_date)->format('d-m-Y') }}</td>
                        <td>{{ $report->description }}</td>
                        <td style="text-align: center">
                            @if ($report->transaction_type == "debit")
                            {{ format_uang($report->amount) }}
                            @endif
                        </td>
                        <td style="text-align: center">
                            @if ($report->transaction_type == "credit")
                            {{ format_uang($report->amount) }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="4" style="text-align: right; padding-right: 20px">
                           <b>TOTAL</b> 
                        </td>
                        <td style="font-weight: 800">{{ format_uang($data->where('transaction_type','debit')->sum('amount')) }}</td>
                        <td style="font-weight: 800">{{ format_uang($data->where('transaction_type','credit')->sum('amount')) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</body>
</html>