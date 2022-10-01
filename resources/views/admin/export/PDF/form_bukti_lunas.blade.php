
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
    <style>
        /* * {
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

        table.table-info-nasabah {
            width: 100%;
        }

        table .label-info {
            width: 30%
        }

        table .label-separator {
            width: 3%
        }

        .column {
            float: left;
            width: 33.33%;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .footer {
            width: 100%;
            position: absolute;
            bottom: 0%;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: -90px;
            right: -90px;
            height: 40px;

            /** Extra personal styles **/
            background-color: #034ff4;
            color: white;
            text-align: center;
            line-height: 25px;
        }

        li {
            text-align: justify;
            text-justify: inter-word;
        }
        table.ttd td{
            text-align: center;
            vertical-align: text-top;
            border: 2px solid black;
            height: 100px;
            width: 25%;
        }
        .separator{
            padding: 0 50px;
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
                Rumah Sakit Umum Pusat Persahabatan<br>
                Nomor : __________/KOKARDA/USIPA/{{ format_bulan(now()) }}/{{ date("Y") }}
            </p>
            <p style="margin-top: 50px; text-align: center; font-weight: 700">
                KWITANSI
            </p>
        </div>
    </section>
    <section class="content">
        <table>
            <table class="content-table">
                <tr>
                    <td>Unit</td>
                    <td class="separator">:</td>
                    <td>_________________</td>
                </tr>
                <tr>
                    <td>Tanggal</td>
                    <td class="separator">:</td>
                    <td>{{ format_tanggal($loan->loanhistory[count($loan->loanhistory)-1]->transaction_date) }}</td>
                </tr>
                <tr>
                    <td>Sudah Terima Dari</td>
                    <td class="separator">:</td>
                    <td>{{ $loan->employee->full_name }}</td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td class="separator">:</td>
                    <td>{{ $loan->employee->nik }}</td>
                </tr>
                <tr>
                    <td>No. Gaji</td>
                    <td class="separator">:</td>
                    <td>{{ $loan->employee->salary_number }}</td>
                </tr>
                <tr>
                    <td style="height: 20px;" colspan="3"></td>
                </tr>
                <tr>
                    <td>Terbilang</td>
                    <td class="separator">:</td>
                    <td>{{ format_uang($loan->loanhistory[count($loan->loanhistory)-1]->total_payment) }}<br>({{ terbilang($loan->loanhistory[count($loan->loanhistory)-1]->total_payment) }})</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td class="separator">:</td>
                    <td>{{ $loan->loanhistory[count($loan->loanhistory)-1]->description }}</td>
                </tr>
            </table>
        </table>
    </section>
    <section class="tanda-tangan">
        <table style="width: 100%; margin-top: 50px;" class="ttd">
            <tr>
                <td>Pembukuan</td>
                <td>Tanda Tangan</td>
                <td>PJ Kredit</td>
                <td>Nasabah</td>
            </tr>
        </table>
    </section>
    <section class="footer">
        <div>
            <p style="text-align: center; margin-bottom: 0px; font-size: 0.8em;">{{ getAppSettingContent('address') }}</p>
        </div>
    </section>
    <footer></footer>
</body>
</html>