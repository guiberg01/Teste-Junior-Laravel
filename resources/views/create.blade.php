@extends('layouts.app')

@section('lis')
    <li class="nav-item" style="list-style: none">
        <a class="nav-link" href="/perfil">Perfil</a>
    </li>
    <li class="nav-item" style="list-style: none">
        <a class="nav-link" href="/produtos/index">Listar Produtos</a>
    </li>
@endsection

@section('content')
    <form action="{{ route('produtos.store') }}" class="mt-4" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome do Produto:</label>
                    <input type="text" class="form-control" id="nome" name="nome" required>
                </div>

                <div class="mb-3">
                    <label for="descricao" class="form-label">Descrição:</label>
                    <textarea class="form-control" id="desc" name="desc" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="preco" class="form-label">Preço:</label>
                    <input type="number" class="form-control" id="preco" name="preco" step="0.01" required>
                </div>

                <div class="mb-3">
                    <label for="qtd_estoque" class="form-label">Quantidade em Estoque:</label>
                    <input type="number" class="form-control" id="qtd_estoque" name="qtd_estoque" required>
                </div>

                <div class="mb-3">
                    <label for="categoria" class="form-label">Categoria:</label>
                    <input type="text" class="form-control" id="categoria" name="categoria" required>
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="imagem" class="form-label">Imagem do Produto:</label>
                    <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required onchange="previewImage(event)">
                </div>
                <div class="card">
                    <div class="card-body" style="display: flex;align-items:center;flex-direction:column;">
                        <h5 class="card-title" id="previewTitle">Preview da Imagem</h5>
                        <img id="imagePreview" src="#" alt="Preview da Imagem" style="display: none; max-height: 80px;"/>
                    </div>
                </div>

                <div class="form-group mt-3">
                <label for="brand">Marca</label>
                <input type="text" class="form-control" id="brand" name="attributes[brand]" placeholder="Digite a marca do produto" required>
                </div>

                <div class="form-group">
                    <label for="model">Modelo</label>
                    <input type="text" class="form-control" id="model" name="attributes[model]" placeholder="Digite o modelo do produto" required>
                </div>

                <div class="form-group">
                    <label for="recommended_age_group">Faixa Etária Recomendada</label>
                    <input type="text" class="form-control" id="recommended_age_group" name="attributes[recommended_age_group]" placeholder="Ex: 0-6 meses" required>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cadastrar Produto</button>
        
    </form>

@endsection

<script defer>
    function previewImage(event) {
        const imagePreview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        const title =document.getElementById('previewTitle');
        
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block'; 
                title.style.display = 'none';
            }
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '#';
            imagePreview.style.display = 'none'; 
            title.style.display = 'block';
        }
    }
</script>
