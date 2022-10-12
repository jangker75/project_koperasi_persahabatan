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
        table .label-info {
            width: 30%
        }
        table.table-simpanan{
            width: 100%;
            border-collapse: collapse;
        }

        table .label-separator {
            width: 3%
        }
        .column-left {
            float: left;
            width: 33.33%;
        }
        .column-right{
            float: right;
            width: 33.33%;
        }
        table.content-table {
            width: 100%;
            border-collapse: separate; 
            border-spacing: 0;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
        .persetujuan-title {
            text-align: center;
        }

        .persetujuan-separator {
            margin-top: 75px;
            text-align: center;
            margin-bottom: 0px;
        }

        .persetujuan-nip {
            margin: 0px;
            padding-left: 50px;
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
                <b>Koperasi Karya Husada RSUP Persahabatan</b><br>
                <b>(KOKARDA)</b><br>
                Badan Hukum No. 2149/B.H./I
            </p>
            <p style="margin-top: 50px;">
                Kepada Yth,<br>
                Ketua Koperasi Karya Husada (KOKARDA)<br>
                RSUP Persahabatan<br>
                Jakarta
            </p>
        </div>
    </section>
    <section class="section-content">
        <p style="margin-top: 0">Dengan hormat,<br>
        Saya yang bertanda tangan dibawah ini :</p>
        <table class="content-table">
            <tr>
                <td class="label-info">{{ __('employee.name') }}</td>
                <td class="label-separator">:</td>
                <td>{{ $employee->full_name }}</td>
            </tr>
            <tr>
                <td class="label-info">{{ __('employee.nik') }}</td>
                <td class="label-separator">:</td>
                <td>{{ $employee->nik }}</td>
            </tr>
            <tr>
                <td class="label-info">{{ __('employee.nip') }}</td>
                <td class="label-separator">:</td>
                <td>{{ $employee->nip }}</td>
            </tr>
            <tr>
                <td class="label-info">Satuan Kerja</td>
                <td class="label-separator">:</td>
                <td>______________________</td>
            </tr>
            <tr>
                <td class="label-info">{{ __('employee.salary_number') }}</td>
                <td class="label-separator">:</td>
                <td>{{ $employee->salary_number }}</td>
            </tr>
            <tr>
                <td class="label-info">{{ __('employee.address_1') }}</td>
                <td class="label-separator">:</td>
                <td>{{ $employee->address_1 }}</td>
            </tr>
        </table>
    </section>
    <section class="content-perjanjian">
        <p>Menyatakan bahwa pada saat ini saya ingin mengundurkan diri dari keanggotaan Koperasi Karya Husada sehubungan dengan masa tugas saya telah berakhir di RSUP Persahabatan Karena: (Lingkari salah satu)
        <br>
        <ol style="margin-bottom: 0">
            <li>Pensiun</li>
            <li>Berhenti Kerja / Berhenti menjadi Pegawai Negeri Sipil</li>
            <li>Pindah kerja ke _______________________________________</li>
        </ol>
        <br>
        Untuk itu saya mohon simpanan saya sebagai anggota Koperasi Karya Husada dapat diperhitungkan dan dapat dikembalikan. Atas kerjasama dan perhatian dari Ketua Koperasi Karya Husada Saya Ucapkan Terimakasih.
        </p>
    </section>
    <section class="persetujuan" >
        <div class="row">
            <div class="column-left">
                <p class="persetujuan-title"><b>Koperasi Karya Husada</b><br>Ketua</p>
                <p class="persetujuan-separator">(.........................................)</p>
                <p class="persetujuan-nip" style="padding-left: 20px !important;">NIP. __________________</p>
            </div>
            <div class="column-right">
                <p class="persetujuan-title">Jakarta, {{ format_tanggal(now()) }}<br>
                    Hormat Saya</p>
                <p class="persetujuan-separator">({{ $employee->full_name }})</p>
                <p class="persetujuan-nip">NIP. {{ $employee->nik }}</p>
            </div>
        </div>
    </section>
    <section class="keterangan">
        <p style="margin: 10px 0 0 0; padding: 0;"><b>Keterangan:</b></p>
        <table style="width: 100%;">
            <tr>
                <td>
                    <table class="table-simpanan">
                        <tr>
                            <td>{{ __('savings_employee.mandatory_savings_balance') }}</td>
                            <td>:</td>
                            <td>{{ format_uang($employee->savings->mandatory_savings_balance) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('savings_employee.principal_savings_balance') }}</td>
                            <td>:</td>
                            <td>{{ format_uang($employee->savings->principal_savings_balance) }}</td>
                        </tr>
                        <tr>
                            <td>{{ __('savings_employee.voluntary_savings_balance') }}</td>
                            <td>:</td>
                            <td>{{ format_uang($employee->savings->voluntary_savings_balance) }}</td>
                        </tr>
                        <tr style="border-bottom: 1px solid black">
                            <td>{{ __('savings_employee.activity_savings_balance') }}</td>
                            <td>:</td>
                            <td>{{ format_uang($employee->savings->activity_savings_balance) }}</td>
                        </tr>
                        <tr>
                            <td><b>Total Simpanan</b></td>
                            <td>:</td>
                            <td><b>{{ format_uang($employee->savings->activity_savings_balance + $employee->savings->voluntary_savings_balance + $employee->savings->principal_savings_balance + $employee->savings->mandatory_savings_balance) }}</b></td>
                        </tr>
                        <tr>
                            <td><b>Yang dibayarkan</b></td>
                            <td>:</td>
                            <td><b>Rp. ____________</b></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="table-pinjaman">
                        <tr>
                            <td>Sisa Pinjaman Uang</td>
                            <td>:</td>
                            <td>Rp. _____________</td>
                        </tr>
                        <tr>
                            <td>Sisa Pinjaman Barang</td>
                            <td>:</td>
                            <td>Rp. _____________</td>
                        </tr>
                        <tr>
                            <td>Sisa Pinjaman Lainnya</td>
                            <td>:</td>
                            <td>Rp. _____________</td>
                        </tr>
                        <tr>
                            <td>Sisa Pinjaman Toko</td>
                            <td>:</td>
                            <td>Rp. _____________</td>
                        </tr>
                    </table>
                </td>
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