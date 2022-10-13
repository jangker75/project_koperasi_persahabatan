<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo/logo.png') }}" />
    <title>Kontrak Permohonan Pinjaman Uang</title>
    <style>
        /* * {
            outline: 1px solid red;
        } */

        .logo-koperasi {
            position: absolute;
            top: 0%;
            left: 0%;
        }

        .page_break {
            page-break-before: always;
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

        table.table-kewajiban>tbody>tr>td {
            font-size: 0.8em;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        .persetujuan-title {
            text-align: center;
        }

        .persetujuan-separator {
            margin-top: 60px;
            text-align: center;
            margin-bottom: 0px;
        }

        .persetujuan-nip {
            margin: 0px;
            padding-left: 30px;
        }

        .syaratketentuan-item>li {
            font-size: 0.8em;
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
        <div class="row">
            <p style="text-align: center;">
                <b>KOPERASI KARYA HUSADA RS PERSAHABATAN</b><br>
                <strong style="font-size: 1.5em;">(KOKARDA)</strong><br>
                Badan Hukum No. 2149/B.H/I
            </p>
            <p style="margin-top: 30px; text-align: center; font-weight: 700">
                SURAT PERMOHONAN PINJAMAN UANG
            </p>
            <div>
                <div style="float: left; width: 65%; margin-top: 45px">
                    <p>
                        Kepada Yth,<br>
                        Koperasi Karya Husada<br>
                        Persahabatan - Jakarta
                    </p>
                </div>
                <div style="float: left; width: auto;">
                    <p style="margin-bottom: 0px; margin-top: 0px;"><strong>Kewajiban :</strong><br></p>
                    <table class="table-kewajiban" style="margin-top: 0px">
                        <tbody>
                            <tr>
                                <td>- Usipa</td>
                                <td>: ....................................</td>
                            </tr>
                            <tr>
                                <td>- BRI</td>
                                <td>: ....................................</td>
                            </tr>
                            <tr>
                                <td>- BTN</td>
                                <td>: ....................................</td>
                            </tr>
                            <tr>
                                <td>- Elektronik</td>
                                <td>: ....................................</td>
                            </tr>
                            <tr>
                                <td>- Toko</td>
                                <td>: ....................................</td>
                            </tr>
                            <tr>
                                <td>- Obat</td>
                                <td>: ....................................</td>
                            </tr>
                            <tr>
                                <td>- Sisa Gaji</td>
                                <td>: ....................................</td>
                            </tr>
                            <tr>
                                <td>- Lain-lain</td>
                                <td>: ....................................</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <section class="info-nasabah">
        <p style="margin-top: -15px; margin-bottom: 6px;">Dengan Hormat<br>Saya yang bertanda tangan di bawah ini</p>
        <table class="table-info-nasabah">
            <tr>
                <td class="label-info">Nama</td>
                <td class="label-separator">:</td>
                <td>{{ $loan->employee->full_name }}</td>
            </tr>
            <tr>
                <td class="label-info">NIP</td>
                <td class="label-separator">:</td>
                <td>{{ $loan->employee->nik }}</td>
            </tr>
            <tr>
                <td class="label-info">Tempat/Tanggal Lahir</td>
                <td class="label-separator">:</td>
                <td>{{ $loan->employee->birthplace }}, {{ format_tanggal($loan->employee->birthday) }}</td>
            </tr>
            <tr>
                <td class="label-info">Pangkat/Golongan</td>
                <td class="label-separator">:</td>
                <td>{{ $loan->employee->department->name ?? "" }}</td>
            </tr>
            <tr>
                <td class="label-info">Satuan Kerja</td>
                <td class="label-separator">:</td>
                <td>.....................................................................................................
                </td>
            </tr>
            <tr>
                <td class="label-info">Telp. Ruang Kerja</td>
                <td class="label-separator">:</td>
                <td>.....................................................................................................
                </td>
            </tr>
            <tr>
                <td class="label-info">Alamat Rumah</td>
                <td class="label-separator">:</td>
                <td>{{ $loan->employee->address_1 }}</td>
            </tr>
            <tr>
                <td class="label-info">No. Rek. Bank</td>
                <td class="label-separator">:</td>
                <td>{{ $loan->employee->rekening }} ({{ \App\Enums\ConstantEnum::BANK[$loan->employee->bank] }})</td>
            </tr>
        </table>
    </section>
    <section class="kontrak-content">
        <p style="margin-bottom: 0px; margin-top: 6px; text-align: justify; text-justify: inter-word;">
            Mengajukan permohonan pinjaman uang sebesar <b>{{ format_uang($loan->total_loan_amount) }}
                ({{ terbilang($loan->total_loan_amount) }} Rupiah)</b><br>
            Pengembalian pinjaman ini sanggup saya angsur selama 5 (lima), 10 (sepuluh), 20 (dua puluh), 30 (tiga puluh)
            bulan, dengan biaya administrasi dan simpanan khusus masing-masing 1% perbulan, mulai dari bulan
            <strong>{{ format_tanggal_tahun($loan->first_payment_date) }} s/d
                {{ format_tanggal_tahun($loan->last_period) }}</strong>. Sebagai pertimbangan. perlu saya informasikan
            bahwa uang pinjaman saya pergunakan untuk
            ...............................................................................................................
        </p>
        {{-- <span style="border-style: dotted; border-bottom: 2px; width: 100px;"></span> --}}
    </section>
    <section class="ketentuan">
        <p style="margin: 0px; text-align: justify; text-justify: inter-word;">
            saya berjanji, apabila dikemudian hari tidak dapat membayar angsuran bulanan yang ditentukan, saya bersedia
            dikenakan denda dan sanksi 5% dari jumlah sisa pinjaman ditambah dengan biaya administrasi 2% per bulan.
            <br>Demikian permohonan pinjaman uang ini saya ajukan, kiranya dapat dipertimbangkan guna memperoleh
            persetujuan.
        </p>
    </section>
    <section class="persetujuan">
        <div class="row">
            <div style="float: left; width: 33.33%">
                <p class="persetujuan-title"><br>Persetujuan Pengurus</p>
                <p class="persetujuan-separator">(.....................................)</p>
                <p class="persetujuan-nip">NIP. </p>
            </div>
            <div style="float: left; width: 33.33%">
                <p class="persetujuan-title">Catatan Bendaharawan Gaji<br>Nomor daftar gaji :<br>Gaji per bulan :</p>
                <p class="persetujuan-separator" style="margin-top: 41px !important;">
                    (.....................................)</p>
                <p class="persetujuan-nip">NIP. </p>
            </div>
            <div style="float: left; width: 33.33%">
                <p class="persetujuan-title">Jakarta, {{ format_tanggal($loan->loan_date) }}<br>
                    Yang Membuat Permohonan</p>
                <p class="persetujuan-separator">({{ $loan->employee->full_name }})</p>
                <p class="persetujuan-nip">NIP. {{ $loan->employee->nik }}</p>
            </div>
        </div>
    </section>
    <section class="syaratketentuan">
        <p style="font-style: italic; margin-bottom: 0px;"><b>Ketentuan :</b></p>
        <ul class="syaratketentuan-item" style="margin: 0px; padding-left: 13px;">
            <li>Penghasilan cukup untuk memenuhi kewajiban kepada Koperasi Karya Husada.</li>
            <li>Pengembalian Formulir permohonan pinjaman paling lambat tanggal 25.</li>
            <li>Konfirmasi pinjaman mulai tanggal 1 s/d 4 di koperasi.</li>
            <li>Pembayaran pinjaman melalui Bank BRI tanggal 5.</li>
            <li>Simpanan Khusus 1/2 % dari besar pinjaman.</li>
        </ul>
    </section>
    <section class="footer">
        <div>
            <p style="text-align: center; margin-bottom: 0px; font-size: 0.8em;">{{ getAppSettingContent('address') }}
            </p>
        </div>
    </section>
    <footer></footer>
    <div class="page_break"></div>
    @include('admin.export.PDF.surat_pernyataan')
</body>

</html>
