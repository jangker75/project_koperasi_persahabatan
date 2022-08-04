<!DOCTYPE html>
<html lang="en">

<head>
    <title>Document</title>
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
    @if (isset($title))
        @if (Request::segment(3) == 'pdf')
            <h2>{{ $title }}</h2>
        @else
            <table>
                <thead>
                    <tr>
                        <td colspan="5" style="font-size: 24">{{ $title }}</td>
                    </tr>
                </thead>
            </table>
        @endif
    @endif
    <table style="width: 100%">
        <thead>
            <tr>
                <td>No</td>
                @foreach ($headers as $header)
                    <td style="padding: 5px"><b>{{ $header }}</b></td>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    @foreach ($data as $item)
                        <td style="padding: 5px">{{ $item }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
    <script type="text/php">
        if ( isset($pdf) ) {
            $font = $fontMetrics->getFont("helvetica", "bold");
            $pdf->page_text(72, 18, "Header: {PAGE_NUM} of {PAGE_COUNT}", $font, 6, array(0,0,0));
        }
    </script>
</body>

</html>
