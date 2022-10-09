<!DOCTYPE html>
<html lang="en">

<head style="position: absolute;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>{{ $order->order_code }}</title>
    <style>
        * {
            font-size: 9px;
            font-family: 'sans-serif';
            margin: 0;
            padding: 0;

        }

        td,
        th,
        tr,
        table {
            /* border-top: 1px solid black; */
            border-collapse: collapse;
        }

        thead {
            border-top: 1px dashed black;
            border-bottom: 1px dashed black;
        }

        th {
            padding: 2px 0;
        }

        td {
            padding: 2px 0;
        }

        td.description,
        th.description {
            width: 50px;
            max-width: 50px;
        }

        td.subtotal,
        th.subtotal {
            width: 50px;
            max-width: 50px;
            text-align: right;
            align-content: right;
        }

        td.quantity,
        th.quantity {
            width: 20px;
            max-width: 20px;
            word-break: break-all;
            text-align: center;
            align-content: center;
        }

        td.price,
        th.price {
            width: 50px;
            max-width: 50px;
            word-break: break-all;
            text-align: center;
        }

        .centered {
            text-align: center;
            align-content: center;
            font-size: 10px;
        }

        th.description {
            text-align: left;
        }

        .ticket {
            width: 180px;
            max-width: 180px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        .colspan {
            text-align: right;
        }

        table.print-friendly tr td,
        table.print-friendly tr th {
            page-break-inside: avoid;
            page-break-after: avoid;
        }

        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }

            table.print-friendly tr td,
            table.print-friendly tr th {
                page-break-inside: avoid;
                page-break-after: avoid;
            }

        }

        .total {
            font-weight: bold;
            border-top: 1px dashed black;
            border-bottom: 1px dashed black;
        }

        .total>td {
            padding: 2px 0;
        }

        .footer {
            width: 165px;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            align-content: center;
            margin-bottom: 24px;
        }

        table.table-header {
            border: 0;
            width: 190px;
        }

        table.table-header>tr {
            border: 0;
        }

        table.table-header>td {
            border: 0;
            font-size: 10px;
            padding: 2px;
        }

        .text-end {
            width: 100%;
            text-align: end;
        }

    </style>
</head>

<body>
    <div class="ticket">
        <p class="centered">Koperasi Karya Husada
            <br>RSUP Persahabatan</p>
        <br><br>
        <table class="table-header">
            <tbody>
                <tr>
                    <td style="width:50%;">Struk #{{ $countBill + 1}}</td>
                    <td class="text-end" style="width:50%;">{{ date('Y-m-d H:m') }}</td>
                </tr>
                <tr>
                    <td colspan="2">Oleh : {{ Auth::user()->employee->full_name }}</td>
                </tr>
                <tr>
                    <td colspan="2">Kasir : {{ Auth::user()->employee->position->name }}</td>
                </tr>
                <tr>
                    <td colspan="2">Kode : {{ $order->order_code}}</td>
                </tr>
                <tr>
                    <td colspan="2">Metode Bayar : {{ $order->transaction->paymentMethod->name}}</td>
                </tr>
                @if ($order->transaction->is_paylater == 1)
                <tr>
                    <td colspan="2">Anggota : {{ $order->transaction->requester->full_name }}</td>
                </tr>
                @endif
            </tbody>
        </table>
        <br>
        <table class="print-friendly">
            <thead>
                <tr>
                    <th class="description">Product</th>
                    <th class="price">Harga</th>
                    <th class="quantity">Jumlah</th>
                    <th class="subtotal">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->detail as $detail)

                <tr>
                    <td class="description">{{ $detail->product_name }}</td>
                    <td class="price">{{ format_uang_no_prefix($detail->price) }}</td>
                    <td class="quantity">{{ $detail->qty }}</td>
                    <td class="subtotal">{{ format_uang_no_prefix($detail->subtotal) }}</td>
                </tr>
                @endforeach
                <tr class="total">
                    <td>Subtotal</td>
                    <td></td>
                    <td></td>
                    <td class="subtotal">{{ format_uang_no_prefix($order->subtotal) }}</td>
                </tr>
                <tr class="total">
                    <td>Discount</td>
                    <td></td>
                    <td></td>
                    <td class="subtotal">{{ format_uang_no_prefix($order->discount) }}</td>
                </tr>
                <tr class="total">
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td class="subtotal">{{ format_uang_no_prefix($order->total) }}</td>
                </tr>
                @if ($order->transaction->is_paylater !== 1)
                <tr class="total">
                    <td>Bayar</td>
                    <td></td>
                    <td></td>
                    <td class="subtotal">{{ format_uang_no_prefix($order->transaction->cash) }}</td>
                </tr>
                <tr class="total">
                    <td>Kembalian</td>
                    <td></td>
                    <td></td>
                    <td class="subtotal">{{ format_uang_no_prefix($order->transaction->change) }}</td>
                </tr>
                @endif
                @if ($order->transaction->is_paylater)
                  <tr class="total">
                    <td>Hutang</td>
                    <td></td>
                    <td></td>
                    <td class="subtotal">{{ format_uang_no_prefix($order->transaction->amount) }}</td>
                  </tr>
                @endif

            </tbody>
        </table>
        <br>
        <p class="footer">Terima kasih telah berbelanja di Koperasi Karya Husada RSUP Persahabatan <br><br>
            www.kokardarspersahabatan.com</p>
        <span>.</span>
    </div>
    <hr>
    <script type="text/javascript">
        try {
            this.print();
        } catch (e) {
            window.onload = window.print;
        }

    </script>
</body>

</html>
