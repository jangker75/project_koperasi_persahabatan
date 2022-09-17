<html>

<head>
    <style>
        #height-container {
            position: absolute;
            left: 0px;
            right: 0px;
            top: 0px;
        }

    </style>
</head>

<body>
    <div id="height-container">
        <div class="ticket">
            <p class="centered">Koperasi Karya Husada
                <br>RSUP Persahabatan</p>
            <br><br>
            <table class="table-header">
                <tbody>
                    <tr>
                        <td style="width:50%;">Struk : #375</td>
                        <td class="text-end" style="width:50%;">{{ date('Y-m-d H:m') }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Oleh : {{ Auth::user()->employee->full_name }}</td>
                    </tr>
                    <tr>
                        <td colspan="2">Kasir : {{ Auth::user()->employee->position->name }}</td>
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
                        <th class="subtotal">Product</th>
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
                        <td class="subtotal">-{{ format_uang_no_prefix($order->discount) }}</td>
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

                </tbody>
            </table>
            <br>
            <p class="footer">Terima kasih telah berbelanja di Koperasi Karya Husada RSUP Persahabatan
                <br>www.kokarda.com</p>
            <span>.</span>
        </div>
    </div>
</body>

</html>
