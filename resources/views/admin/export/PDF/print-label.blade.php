<!DOCTYPE html>
<html lang="en">

<head style="position: absolute;">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <title>cetak label</title>
    <style>
        * {
            font-size: 11px;
            font-family: 'sans-serif';
            margin: 0;
            padding: 0;

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

        h5{
          font-size: 16px;
        }

        .canvas{
          border: 1px solid black;
          position: absolute;
          /* padding: 34px 8px; */
        }

        td,
        th,
        tr,
        table {
            /* border-top: 1px solid black; */
            border-collapse: collapse;
        }

        .pitch{
          /* border: 1px solid green; */
          position: relative;
        }

        .label{
          position: absolute;
          border: 2px solid black;
          top: 0;
          left: 0;
          display: flex;
          justify-content: center;
          align-items: center;
          padding: 2px;
          box-sizing: border-box;
        }

        .layout{
          /* border: 1px solid green; */
          display: grid;
          grid-template-columns: auto auto auto;
        }

        .content{
          display: flex;
          flex-direction: column;
          justify-content: center;
          align-items: center;
        }

        .text-name{
          max-width: 180px;
        }
    </style>
</head>

<body>
    <div class="canvas">
        <div class="layout">
          @foreach ($product as $prod)
          <div class="pitch">
            <div class="label">
              <div class="content">
                <div>
                  {!! $prod->barcode !!}
                </div>
                <h5 class="text-name" style="margin-top: 4px; text-align:center;">{{ $prod->name }}</h5>
                <h5>{{ format_uang($prod->price) }}</>
              </div>
            </div>
          </div>
          @endforeach
        </div>
        {{-- <table>
          <tr>
            <td class="pitch">
              <div class="label">
                {!! $product[0]['barcode'] !!}
              </div>
            </td>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
          </tr>
          <tr>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
          </tr>
          <tr>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
          </tr> 
          <tr>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
            <td class="pitch">
              <div class="label">Hallo</div>
            </td>
          </tr> 
        </table> --}}
    </div>
    <script>
      let verticalPitch = parseInt("{{ $height }}") + 27;
      let horizontalPitch = parseInt("{{ $width }}") + 15;

      var pitch = document.querySelectorAll(".pitch");

      pitch.forEach(element => {

        // element.style.height = verticalPitch+"px";
        // element.style.width = horizontalPitch+"px";
        element.style.height = "{{ $height+1 }}px";
        element.style.width = "{{ $width+1 }}px";
      });
      
      var label = document.querySelectorAll(".label");
      
      label.forEach(element => {
        element.style.height = "{{ $height }}px";
        element.style.width = "{{ $width }}px";
      })

      console.log(verticalPitch, horizontalPitch)
    </script>    
</body>

</html>
