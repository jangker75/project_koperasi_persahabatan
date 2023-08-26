<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

    </style>
</head>

<body>
    <table style="width: 100%">
        <thead>
            <tr>
                <th align="center" rowspan="2">No</th>
                <th align="center" rowspan="2">produk</th>
                <th align="center" rowspan="2">sku</th>
                <th align="center" rowspan="2">lokasi</th>
                <th align="center" rowspan="2">biaya</th>
                <th align="center" rowspan="2">harga</th>
                <th align="center" rowspan="2">jumlah</th>
                <th align="center" colspan="2">nilai (Rp)</th>
            </tr>
            <tr>
                <th align="center">biaya</th>
                <th align="center">harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
              <tr>
                <td>{{ $data->id }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ strval($data->sku) }}</td>
                <td>{{ $data->store_name }}</td>
                <td>{{ ($data->cost)  }}</td>
                <td>{{ ($data->revenue) }}</td>
                <td>{{ $data->qty }}</td>
                <td>{{ ($data->cost*$data->qty) }}</td>
                <td>{{ ($data->revenue*$data->qty) }}</td>
              </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
