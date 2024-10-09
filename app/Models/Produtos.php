<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    use HasFactory;

    protected $fillable = [
        'idProduto',
        'nome',
        'desc',
        'preco',
        'qtd_estoque',
        'categoria',
        'imagem',
    ];
}
