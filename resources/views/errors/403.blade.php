<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error - {{ $exception->getMessage() }}</title>
    @include('errors.403-style')
</head>

<body>
    <div id="notfound">
        <div class="notfound">
            <div class="notfound-404">
                <h1>Oops!</h1>
                <h2>403 - {{ $exception->getMessage() }}</h2>
            </div>
            <a href="{{ url('admin') }}">Go to Homepage</a>
        </div>
    </div>
</body>

</html>
