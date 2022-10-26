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
            margin-top: 100px;
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
        .separator1{
            padding: 0 20px 0 20px;
        }
        .separator{
            padding: 0 20px 0 120px;
        }
        .pasal-title{
            font-weight: 800;
            text-align: center;
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
    <section class="kop-surat" style="margin-bottom: 20px;">
        <div>
            <p style="text-align: center;">
                <u style="font-size: 1.1em;"><b>{{ $titleFormAkad }}</b></u>
            </p>
            <p style="text-align: center; margin-top: -10px;">
                <b>KOPERASI KARYA HUSADA</b><br>
                Nomor : __________/Usipa/Kokarda/____/20_____
            </p>
            {{-- <p style="margin-top: 50px; text-align: center; font-weight: 700">
                Form Akad
            </p> --}}
        </div>
    </section>
    <section class="content">
        <p style="text-indent: 50px;">Pada hari ini, tanggal {{ \Carbon\Carbon::parse($loan->response_date)->format('d') }} bulan {{ \Carbon\Carbon::parse($loan->response_date)->format('m') }} tahun {{ \Carbon\Carbon::parse($loan->response_date)->format('Y') }} Yang bertanda tangan dibawah ini:</p>
        <table class="content-table">
            <tr>
                <td>Nama</td>
                <td class="separator1">:</td>
                <td>{{ $loan->employee->full_name }}</td>
            </tr>
            <tr>
                <td>Nomor Induk Koperasi</td>
                <td class="separator1">:</td>
                <td>{{ $loan->employee->nik }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td class="separator1">:</td>
                <td>{{ $loan->employee->address_1 }}</td>
            </tr>
        </table>
        <p>Dalam hal ini bertindak atas nama sendiri dan untuk selanjutnya disebut <b>DEBITUR</b></p>
        <table class="content-table">
            <tr>
                <td>Nama</td>
                <td class="separator">:</td>
                <td>___________________________________________</td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td class="separator">:</td>
                <td>___________________________________________</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td class="separator">:</td>
                <td>___________________________________________</td>
            </tr>
        </table>
        <p style="text-indent: 50px;">
            Dalam hal ini bertindak atas nama Koperasi Karya Husada (KOKARDA) RSUP Persahabatan yang berwenang mewakili KOKARDA RSUP Persahabatan yang selanjutnya disebut <b>KREDITUR</b>.
        </p>
    </section>
    <section class="pasal">
        <p>
            Kedua belah pihak dengan ini menerangkan bahwa antara KREDITUR dan DEBITUR sepakat dan karenanya yang telah disepakati bersama, sebagaimana diatur dalam pasal pasal berikut:
        </p>
        <p class="pasal-title">Pasal 1</p>
        <p class="pasal-content">
            KREDITUR telah memberikan kepada DEBITUR berupa pinjaman uang sebesar {{ format_uang($loan->total_loan_amount) }} ( {{ terbilang($loan->total_loan_amount) }} ) dan DEBITUR menyatakan mengaku dan menerima pinjaman uang tersebut yang akan digunakan Untuk ___________________________________. Jumlah tersebut belum termasuk jasa pinjaman dan simpanan Khusus dan Biaya lainya yang timbul berdasarkan perjanjian ini, untuk selanjutnya disebut PINJAMAN.
        </p>
        <p class="pasal-title">Pasal 2</p>
        <p class="pasal-content">
            DEBITUR harus membayar kepada KREDITUR berupa :<br>
            <table style="margin-left: 75px;">
                <tbody>
                    <tr>
                        <td>a.</td>
                        <td>Jasa Pinjaman</td>
                        <td style="padding: 0 15px">:</td>
                        <td>Sebesar 1% per bulan aktif</td>
                    </tr>
                    <tr>
                        <td>b.</td>
                        <td>Simpanan Khusus</td>
                        <td style="padding: 0 15px">:</td>
                        <td>Sebesar 0,5% per bulan efektif</td>
                    </tr>
                    <tr>
                        <td>c.</td>
                        <td>Jaminan Kredit</td>
                        <td style="padding: 0 15px">:</td>
                        <td>Potong Gaji</td>
                    </tr>
                </tbody>
            </table>
        </p>
        
        <p class="pasal-title">Pasal 3</p>
        <p class="pasal-content">
            Pinjaman diberikan jangka waktu {{ $loan->total_pay_month }} bulan, dimulai bulan {{ \Carbon\Carbon::parse($loan->first_payment_date)->format('m-Y') }} s/d {{ \Carbon\Carbon::parse($loan->last_period)->format("m-Y") }} dengan cicilan per bulan {{ format_uang($loan->first_payment_amount) }} dibayar setiap diterimanya gaji pegawai atau tanggal 1 setiap bulannya.
        </p>
        <section class="footer">
            <div>
                <p style="text-align: center; margin-bottom: 0px; font-size: 0.8em;">{{ getAppSettingContent('address') }}</p>
            </div>
        </section>
        <footer></footer>
        <div style="page-break-before: always;"></div>
        <p class="pasal-title">Pasal 4</p>
        <p class="pasal-content">
            Dalam hal peminjaman kembali kedua belah pihak setuju akan diberikan setelah pembayaran 50% masa angsuran. Dan apabila anggota mengalami terlambat bayar akan dikenakan sanksi tidak diberikan lagi pinjaman selama beberapa waktu dan rekening atas nama DEBITUR di blokir sesuai ketentuan yang berlaku di KOKARDA RSUP Persahabatan.
        </p>
        <p class="pasal-title">Pasal 5</p>
        <p class="pasal-content">
            Apabila dikemudian hari terjadi PHK / Pindah kerja, maka seluruh pendapatan yang saya peroleh dari Perusahaan / Instansi maupun Koperasi, antara lain: Gaji, Simpanan Pokok, Simpanan Wajib dan Simpanan Khusus,serta SHU Koperasi akan menjadi sumber pelunasan pinjaman saya. Namun apabila tidak mencukupi, maka saya bersedia untuk melunasi pinjaman tersebut dari sumber lainnya dan akan ditanggung oleh pihak ahli waris saya.
        </p>
        <p class="pasal-title">Pasal 6</p>
        <p class="pasal-content">
            Mengenai perjanjian ini segala akibat hukumnya, kedua belah pihak memilih domisili hukum yang tetap di kantor panitera pengadilan Jakarta Timur.
            <br>
            Demikian surat perjanjian ini disetujui dan ditandatangani.
        </p>
    </section>
    <section class="persetujuan" style="margin-top:25px;">
        <div class="row" style="margin-top: 50px">
            <div style="float: left; width: 50%">
                <p style="font-weight: 800;"><br>
                    KREDITUR<br>Koperasi Karya Husada<br>"KOKARDA" RSUP Persahabatan</p>
                <p style="text-align: left" class="persetujuan-separator">...............................................</p>
                <p>Ketua : </p>
            </div>
            <div style="float: right; width: 50%">
                <p style="text-align: center">Jakarta, {{ format_tanggal($loan->loan_date) }}</p>
                <p style="text-align: center"><br>
                    <b>DEBITUR</b></p>
                <p class="persetujuan-separator" style="text-align: center">({{ $loan->employee->full_name }})</p>
                <p style="text-align: left; padding-left: 90px">NIP : </p>
            </div>
        </div>
    </section>
    <section class="footer">
        <div>
            <p style="text-align: center; margin-bottom: 0px; font-size: 0.8em;">{{ getAppSettingContent('address') }}</p>
        </div>
    </section>
    <footer></footer>
</body>
</html>