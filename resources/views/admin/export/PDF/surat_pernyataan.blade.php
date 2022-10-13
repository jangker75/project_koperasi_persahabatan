<section class="surat-pernyataan">
    <p style="text-align: center; margin-bottom: 50px; font-size: 1.5em">SURAT PERNYATAAN</p>
    <table>
        <tbody>
            <tr>
                <td class="label-info">Yang Bertanda tangan di bawah ini</td>
                <td>:</td>
            </tr>
            <tr>
                <td class="label-info">Nama</td>
                <td>: {{ $loan->employee->full_name }}</td>
            </tr>
            <tr>
                <td class="label-info">NIP</td>
                <td>: {{ $loan->employee->nip }}</td>
            </tr>
            <tr>
                <td class="label-info">NIK</td>
                <td>: {{ $loan->employee->nik }}</td>
            </tr>
            <tr>
                <td class="label-info">Tempat Tanggal Lahir</td>
                <td>: {{ $loan->employee->birthplace }}, {{ format_tanggal($loan->employee->birthday) }}</td>
            </tr>
            <tr>
                <td class="label-info">Jabatan</td>
                <td>:</td>
            </tr>
            <tr>
                <td class="label-info">Bagian/Unit Kerja</td>
                <td>: {{ $loan->employee->department->name ?? ""}}</td>
            </tr>
            <tr>
                <td class="label-info">Alamat</td>
                <td>: {{ $loan->employee->address_1 }}</td>
            </tr>
            <tr>
                <td class="label-info">No Tlp/HP</td>
                <td>: {{ $loan->employee->phone }}</td>
            </tr>
            <tr>
                <td class="label-info">Menyatakan dengan sebenarnya bahwa</td>
                <td>:</td>
            </tr>
        </tbody>
    </table>
    <ol>
        <li>Terhitung mulai tanggal {{ format_tanggal($loan->loan_date) }} saya meminjam uang/barang di kokarda
            sebesar {{ format_uang($loan->total_loan_amount) }} ({{ terbilang($loan->total_loan_amount) }} Rupiah).</li>
        <li>Pinjaman tersebut akan saya cicil selama {{ $loan->total_pay_month }} Bulan terhitung mulai bulan
            {{ \Carbon\Carbon::parse($loan->first_payment_date)->format('m') }} tahun
            {{ \Carbon\Carbon::parse($loan->first_payment_date)->format('Y') }} sampai dengan bulan
            {{ \Carbon\Carbon::parse($loan->last_period)->format('m') }} Tahun
            {{ \Carbon\Carbon::parse($loan->last_period)->format('Y') }}</li>
        <li>Apabila dikemudian hari saya berhenti atau kontrak kerja saya di putus oleh RSUP Persahabatan, sementara
            cicilan belum lunas, maka saya akan membayar lunas sesuai dengan peraturan yang berlaku</li>
    </ol>
    <p>Demikian pernyataan ini dibuat dengan sebenar-benarnya dan saya sanggup di tuntut dimuka pengadilan apabila
        semua keterangan yang diberikan tidak benar.</p>

    <div class="row" style="margin-top: 50px">
        <div style="float: left; width: 50%">
            <p><br>
                Mengetahui,</p>
            <p>Kepala instalasi/Bidang/Bagian</p>
            <p style="text-align: left" class="persetujuan-separator">...............................................</p>
            <p>NIP : </p>
        </div>
        <div style="float: right; width: 50%">
            <p style="text-align: center">Jakarta, {{ format_tanggal($loan->loan_date) }}</p>
            <p style="text-align: center"><br>
                Yang memberi pernyataan,</p>
            <p class="persetujuan-separator" style="text-align: center">...............................................</p>
            <p style="text-align: left; padding-left: 90px">NIP : </p>
        </div>
    </div>
</section>