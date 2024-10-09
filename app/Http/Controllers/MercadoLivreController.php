<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use App\Services\MercadoLivreService;

class MercadoLivreController extends Controller
{
    protected $mercadoLivreService;

    public function __construct(MercadoLivreService $mercadoLivreService)
    {
        $this->mercadoLivreService = $mercadoLivreService;
    }

}