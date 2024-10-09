@extends('layouts.app')

@section('lis')
    <li class="nav-item" style="list-style: none">
        <a class="nav-link" href="/produtos/create">Criar Produtos</a>
    </li>

    <li class="nav-item" style="list-style: none">
        <a class="nav-link" href="/perfil">Perfil</a>
    </li>
@endsection

@section('content')
    <h1 class="mt-3 mb-4">Meus Produtos</h1>
    @if (isset($produtosNoBanco) && count($produtosNoBanco) > 0)
        <div class="row">
            @foreach ($produtosNoBanco as $produto)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <img src="{{ $produto->imagem }}" class="card-img-top" alt="{{ $produto->nome }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $produto->nome }}</h5>
                            <p class="card-text">Id do Produto: {{ $produto->idProduto }}</p>
                            <p class="card-text">Descrição: {{ $produto->desc }}</p>
                            <p class="card-text">Categoria: {{ $produto->categoria }}</p>
                            <p class="card-text">Preço: R$ {{ number_format($produto->preco, 2, ',', '.') }}</p>
                            <p class="card-text">Quantidade: {{ $produto->qtd_estoque }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-warning">Você não tem produtos cadastrados.</div>
    @endif
@endsection