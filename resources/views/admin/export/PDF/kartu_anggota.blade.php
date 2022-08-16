<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $employee->name }}</title>
    <style>
        /* * {
            outline: 1px solid red;
        } */

        .table-content {
            width: 60%;
            border: 0;
            margin-left: 5%;
            margin-top: 30px;
        }

        @page {
            margin: 0px 0px 0px 0px !important;
            padding: 0px 0px 0px 0px !important;
        }

        .logo-rs {
            position: absolute;
            top: 0%;
            left: 0%;
        }
        .foto-profile{
            position: absolute;
            right: 5%;
            top: 30%;
        }
        .foto-profile table td{
            text-align: center;
        }

        .kop-surat {
            position: absolute;
            top: 0%;
            left: 0%;
            width: 100%;
            padding-left: 10%;
            color: white;
        }

        .card-header {
            width: 100%;
            height: 25%;
            background-color: rgb(5, 81, 114);
        }
        .card-footer {
            position: absolute;
            bottom: 0%;
            width: 100%;
            height: 10%;
            background-color: rgb(5, 81, 114);
        }
    </style>
</head>

<body>
    <div class="logo-rs">
        <img src="{{ asset('assets/images/logo/logo2.png') }}" width="170px" height="100px" alt="">
    </div>

    <div class="card-header"></div>
    <div class="kop-surat">
        <p style="text-align: center; ">
            <b style="font-size: 1.2em">KOPERASI KARYA HUSADA RS PERSAHABATAN</b><br>
            <strong style="font-size: 0.8em;">{{ getAppSettingContent('address') }}</strong>
            <br>
            <span style="font-size: 0.9em">Badan Hukum No. 2149/B.H/I</span>
        </p>
    </div>
    <div class="foto-profile">
        <table>
            <tr>
                <td>
                    <img src="{{ ($employee->user->profile_image != null) 
                        ? url('storage/' . $employee->user->profile_image)
                        :  url('storage/default/noimage.png') }}" style="width: 160px; height: 160px;">
                </td>
            </tr>
            {{-- <tr>
                <td>
                    <img style="width: 160px; height: 50px;" src="https://pictures-ghana.jijistatic.com/19092001_MTMwMC03NjktNDg3NDJiNGY5Nw.jpg" alt="">
                </td>
            </tr> --}}
            <tr>
                <td style="align-content: center">
                    <img src="data:image/png;base64,{!! DNS1D::getBarcodePNG($employee->nik, 'C128',1,33,array(1,1,1)) !!}" alt="barcode"/>
                </td>
            </tr>
        </table>
        
            
    </div>
    <table class="table-content">
        <tr>
            <td colspan="2" style="text-align: center;padding-bottom: 10px; font-size: 1.5em;" colspan="2">KARTU
                ANGGOTA KOPERASI</td>
        </tr>
        <tr>
            <td style="width: 25%;">Nama</td>
            <td>{{ $employee->full_name }}</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>{{ $employee->nik }}</td>
        </tr>
        <tr>
            <td>Jenis Kelamin</td>
            <td>{{ \App\Enums\ConstantEnum::GENDER[$employee->gender] }}</td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>{{ $employee->address_1 }}</td>
        </tr>
    </table>
    <div class="card-footer"></div>
</body>

</html>
