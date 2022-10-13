<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ env('APP_NAME') }}">
    <!-- FAVICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo/logo.png') }}" />
    <title>Kontrak Permohonan Kredit Barang</title>
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

        .persetujuan-title {
            text-align: center;
        }

        .persetujuan-separator {
            margin-top: 45px;
            text-align: center;
            margin-bottom: 0px;
        }

        .persetujuan-nip {
            margin: 0px;
            padding-left: 30px;
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
                <b>KOPERASI KARYA HUSADA RS PERSAHABATAN</b><br>
                <strong style="font-size: 1.5em;">(KOKARDA)</strong><br>
                Badan Hukum No. 2149/B.H/I
            </p>
            <p style="margin-top: 50px; text-align: center; font-weight: 700">
                PERMOHONAN KREDIT BARANG
            </p>
            <p style="margin-top: 50px;">
                Yth Koperasi Karya Husada<br>
                RS. Persahabatan<br>
                Jakarta
            </p>
        </div>
    </section>
    <section class="info-nasabah">
        <p>Yang bertanda tangan di bawah ini saya,</p>
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
                <td>{{ $loan->employee->department->name ?? ""}}</td>
            </tr>
            <tr>
                <td class="label-info">Satuan Organisasi/Telp/Pes</td>
                <td class="label-separator">:</td>
                <td>{{ $loan->employee->phone }}</td>
            </tr>
        </table>
    </section>
    <section class="kontrak-content">
        <p>Mohon kepada saya diberikan Kredit barang dari Koperas Karya Husada RS. Persahabatan Jakarta berupa :</p>
        <table class="table-info-nasabah">
            <tr>
                <td class="label-info">Jenis Barang</td>
                <td class="label-separator">:</td>
                <td>.....................................................................................................
                </td>
            </tr>
            <tr>
                <td class="label-info">Merk</td>
                <td class="label-separator">:</td>
                <td>.....................................................................................................
                </td>
            </tr>
            <tr>
                <td class="label-info">Harga</td>
                <td class="label-separator">:</td>
                <td>{{ format_uang($loan->total_loan_amount) }} ({{ terbilang($loan->total_loan_amount) }} Rupiah)</td>
            </tr>
            <tr>
                <td class="label-info">Barang diambil di</td>
                <td class="label-separator">:</td>
                <td>Koperasi Karya Husada RS. Persahabatan</td>
            </tr>
        </table>
    </section>
    <section class="ketentuan">
        <p>Ketentuan/Persyaratan perihal kredit barang tersebut patut saya ketahui dan taati adalah sbb :</p>
        <ol>
            <li>Kredit barang tersebut sanggup diangsur selama 5 (lima), 10 (sepuluh) bulan dimulai dengan angsuran
                pertama pada bulan <strong>{{ format_tanggal_tahun($loan->first_payment_date) }} s/d
                    {{ format_tanggal_tahun($loan->last_period) }}</strong></li>
            <li>Apabila anggota yang bersangkutan tidak dapat melunasi suatu angsuran maka dikenakan sanksi sesuai
                dengan peraturan simpan pinjam</li>
            <li>Barang yang sudah diterima anggota, sepenuhnya merupakan tanggung jawab anggota dengan pihak pabrik
                (dealer) Kokarda tidak bertanggung jawab terhadap kerusakan-kerusakan barang tersebut.</li>
            <li>Setelah disetujui oleh Pengurus Kokarda kredit barang tersebut tidak dapat diubah atau dibatalkan</li>
        </ol>
    </section>
    <section class="persetujuan">
        <div class="row">
            <div class="column">
                <p class="persetujuan-title">Mengetahui<br>Pengurus Kokarda</p>
                <p class="persetujuan-separator">(.........................................)</p>
                <p class="persetujuan-nip">NIP. </p>
            </div>
            <div class="column">
                <p class="persetujuan-title"> <br>Bendahara Gaji RSP</p>
                <p class="persetujuan-separator">(.........................................)</p>
                <p class="persetujuan-nip">NIP. </p>
            </div>
            <div class="column">
                <p class="persetujuan-title">Jakarta, {{ format_tanggal($loan->loan_date) }}<br>
                    Pemohon</p>
                <p class="persetujuan-separator">({{ $loan->employee->full_name }})</p>
                <p class="persetujuan-nip">NIP. {{ $loan->employee->nik }}</p>
            </div>
        </div>
    </section>
    <section class="footer">
        <div>
            <p style="text-align: center; margin-bottom: 0px; font-size: 0.8em;">{{ getAppSettingContent('address') }}</p>
        </div>
    </section>
    <footer></footer>
    <div class="page_break"></div>
    @include('admin.export.PDF.surat_pernyataan')
</body>

</html>
