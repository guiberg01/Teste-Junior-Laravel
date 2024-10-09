@extends('layouts.app')

@section('css_proprio')
{{secure_asset('css/main.css')}}
@endsection

@section('content')
    <main class="container gap-2 text-center">
        <div class="row mt-5 mb-3">
            <h2>Para começar a utilizar clique no botão abaixo para gerar seu accessToken.</h2>
        </div>
        <div class="row mb-5 text-center">
            <a href="/login">Logar</a>
        </div>
        <div class="row text-sm-center">
            <h3>Certifique-se de atualizar as variaveis de ambiente com as informações corretas.</h3>
        </div>
        
    </main>
    
</body>
</html>

@endsection