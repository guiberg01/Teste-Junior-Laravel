<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Projeto Junior')</title>
    <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="@yield('css_proprio')" rel="stylesheet">
</head>
<body style="box-shadow: inset 0px 55px #ededed;">
    <div class="container mb-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-light" id="nav">
            <a class="navbar-brand text-center" href="{{ url('/') }}">Projeto Junior</a>
            @yield('lis')
        </nav>

        @if (session('error'))
        <div class="alert alert-danger mt-5 mb-4" onclick="this.style.display = 'none';" style="cursor: pointer;">
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->has('categoria'))
        <div class="alert alert-danger mt-5 mb-4" onclick="this.style.display = 'none';" style="cursor: pointer;">
            {{ $errors->first('categoria') }}
        </div>
        @endif

        @if ($errors->has('imagem'))
        <div class="alert alert-danger mt-5 mb-4" onclick="this.style.display = 'none';" style="cursor: pointer;">
            {{ $errors->first('imagem') }}
        </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success" onclick="this.style.display = 'none';" style="cursor: pointer;">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </div>
    
    <script src="{{ secure_asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
