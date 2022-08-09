<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ isset($title) ? $title : 'Report' }}</title>
    <style>
        table,
        th,
        td {
            padding: 5px;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .logo-koperasi {
            position: absolute;
            top: 0%;
            left: 0%;
        }
    </style>
</head>

<body>
    <div class="logo-koperasi">
        <img src="{{ asset('assets/images/logo/logo4.png') }}" width="100px" height="100px" alt="">
        <p style="margin-top: 0px">Koperasi Karya Husada</p>
    </div>
    <p style="text-align: center; font-size: 28px; margin-bottom: 70px;">Rekap Pelunasan Pinjaman karyawan</p>
    <table style="width: 100%;">
        <thead>
            <tr style="background-color: rgb(85, 205, 245); border-bottom: 4px double black;">
                <th>No.</th>
                <th>Register</th>
                <th>NIP</th>
                <th>Nama Karyawan</th>
                <th>No Kontrak</th>
                <th>Pokok</th>
                <th>Bunga</th>
                <th>Adm</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loans as $key => $loan)
                <tr>
                    <td colspan="9" style="font-weight: bold">Tanggal : {{ $key }}</td>
                </tr>
                @foreach ($loan as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->employee->nip }}</td>
                        <td>{{ $item->employee->nik }}</td>
                        <td>{{ $item->employee->full_name }}</td>
                        <td>{{ $item->transaction_number }}</td>
                        <td>{{ format_uang($item->remaining_amount) }}</td>
                        <td>{{ format_uang($item->actual_interest_amount) }}</td>
                        <td>{{ format_uang($item->admin_fee) }}</td>
                        <td>{{ format_uang($item->remaining_amount + $item->actual_interest_amount + $item->admin_fee) }}</td>
                    </tr>
                @endforeach
                <tr style="font-weight: bold; border-bottom: 4px double black;">
                    <td style="text-align: right;" colspan="5">Total Tanggal {{ $key }} :</td>
                    <td>{{ format_uang(collect($loan)->sum('remaining_amount')) }}</td>
                    <td>{{ format_uang(collect($loan)->sum('actual_interest_amount')) }}</td>
                    <td>{{ format_uang(collect($loan)->sum('admin_fee')) }}</td>
                    <td>{{ format_uang(collect($loan)->sum('remaining_amount') + collect($loan)->sum('actual_interest_amount') + collect($loan)->sum('admin_fee')) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
