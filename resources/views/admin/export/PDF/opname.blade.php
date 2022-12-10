<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form Opname {{ $location->name }} - {{ date('d/m/Y') }}</title>
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

        table.content-table {
            width: 100%;
            border-collapse: collapse; 
            /* border-spacing: 0.6em; */
        }
        tr,th,td{
          border: 1px solid black;
        }

        table .label-info {
            width: 30%
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

        li {
            text-align: justify;
            text-justify: inter-word;
        }

        td{
          padding: 1px;
        }
        /* .col-name,.col-sku{
          width: 40%;
        } */
        .col-data,.col-temuan, .col-diff, .col-number{
          width:5%;
          text-align: center;
        }
        /* .col-desc{
          width: 40%;
        } */

        .text-uppercase{
          text-transform: uppercase;
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
            <p style="margin-top: 50px; margin-bottom: 50px; text-align: center; font-weight: 700">
                FORMULIR STOCK OPNAME <?php date('DD-MM-YYYY') ?>
            </p>
            <p class="text-uppercase">Lokasi : {{ $location->name }}</p>
            <p class="text-uppercase">Metode : {{ $title }}</p>
        </div>
    </section>
    <section class="content-nasabah">
        <table class="content-table">
            <thead>
              <tr>
                <th class="col-number">No</th>
                <th class="col-name">Nama Produk</th>
                {{-- <th class="col-sku">SKU</th> --}}
                <th class="col-data">Data</th>
                @if (request('mode') == 'orderToday')
                  <th>Jumlah terjual</th>
                @endif
                <th class="col-temuan">Jumlah Temuan</th>
                <th class="col-diff">Jumlah Perbedaan</th>
                {{-- <th class="col-desc">Keterangan</th> --}}
              </tr>
            </thead>
            <tbody>
              @foreach ($opname as $i => $opnam)
                <tr>
                  <td>{{ $i+1 }}</td>
                  <td>{{ $opnam->name }}</td>
                  {{-- <td>{{ $opnam->sku }}</td> --}}
                  <td class="col-data">{{ $opnam->qty }}</td>
                  @if (request('mode') == 'orderToday')
                    <td style="text-align: center;">{{ $opnam->qtyOrder }}</td>
                  @endif
                  <td></td>
                  <td></td>
                  {{-- <td></td> --}}
                </tr>
              @endforeach
            </tbody>
        </table>
    </section>
    {{-- <section style="margin-top: 25px;">
        <p>Mohon dicatat sebagai anggota <strong>KOPERASI KARYA HUSADA RSUP PERSAHABATAN (KOKARDA)</strong> terhitung
            mulai tanggal {{ format_tanggal($employee->created_at) }}</p>
        <ol>
            <li>Bersedia memenuhi ketentuan pada Anggaran Dasar dan Anggaran RUmah Tangga KOKARDA</li>
            <li>Membayar uang simpanan Pokok dan Simpanan Wajibyang besarannya diatur dalam Rapat Anggota Tahunan (RAT).</li>
        </ol>
        <p>Atas Perhatiannya saya ucapkan terimakasih.</p>
    </section>
    <section class="persetujuan" style="margin-top:25px;">
        <div class="row">
            <div class="column-left">
                <p class="persetujuan-title">Mengetahui<br>Pengurus Kokarda</p>
                <p class="persetujuan-separator">(.........................................)</p>
                <p class="persetujuan-nip">NIP. </p>
            </div>
            <div class="column-right">
                <p class="persetujuan-title">Jakarta, {{ format_tanggal(now()) }}<br>
                    Pemohon</p>
                <p class="persetujuan-separator">({{ $employee->full_name }})</p>
                <p class="persetujuan-nip">NIP. {{ $employee->nik }}</p>
            </div>
        </div>
    </section>
    <section>
        <p>Catatan :<br>
            Mohon Siapkan Persyaratan Berikut : Fotocopy KTP, Fotocopy Nametag, Fotocopy Ijazah Terakhir (Untuk Karyawan BLU dan Kontrak), Fotocopy SK Terakhir (Untuk PNS).
            </p>
    </section> --}}
    {{-- <section class="footer">
        <div>
            <p style="text-align: center; margin-bottom: 0px; font-size: 0.8em;">{{ getAppSettingContent('address') }}</p>
        </div>
    </section>
    <footer></footer> --}}
    <script>
      // window.print();
    </script>
</body>

</html>
