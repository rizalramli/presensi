@php
    $sql = 'SELECT * FROM instansi';
    
    $result = DB::selectOne($sql);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $result->nama_sekolah }}</title>

    @include('layouts.css')

</head>

<body>
    <div id="app">

        <div style="padding:2rem">
            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; {{ $result->nama_sekolah }}</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @include('layouts.js')

</body>

</html>
