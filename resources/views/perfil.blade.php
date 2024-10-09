@extends('layouts.app')

@section('lis')
    <li class="nav-item" style="list-style: none">
        <a class="nav-link" href="/produtos/create">Criar Produto</a>
    </li>
    <li class="nav-item" style="list-style: none">
        <a class="nav-link" href="/produtos/index">Listar Produtos</a>
    </li>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Nome do Usuário</h5>
                        @foreach ($responseData as $key => $value)
                            <li>{{ $key }}: {{ $value }}</li>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header">
                        Instruções
                    </div>
                    <div class="card-body">
                        <a href="/produtos/create" class="btn btn-primary mb-3">Criar Produto</a>
                        <a href="/produtos/index" class="btn btn-primary mb-3">Listar Produtos</a>
                        <h5 class="card-title">Agora você pode criar e listar os produtos</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection