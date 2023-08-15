<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MA MIFTAHUL ULUM PANDANWANGI</title>

    @include('layouts.css')

</head>

<body>
    <div id="app">

        <div style="padding:2rem">

            @yield('content')

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2023 &copy; MA MIFTAHUL ULUM PANDANWANGI</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @include('layouts.js')

</body>

</html>
