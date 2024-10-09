<?php

namespace App\Http\Controllers;
use App\Services\MercadoLivreService;
use Illuminate\Support\Facades\Http;
use App\Models\Produtos;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    protected $mercadoLivreService;

    public function __construct(MercadoLivreService $mercadoLivreService)
    {
        $this->mercadoLivreService = $mercadoLivreService;
    }
    public function create()
    {
        return view('create');
    }

    public function store(Request $request)
    {   

        $request->validate([
            'nome' => 'required|string',
            'desc' => 'required|string',
            'preco' => 'required|numeric',
            'qtd_estoque' => 'required|integer',
            'categoria' => 'required|string',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'attributes.brand' => 'required|string',
            'attributes.model' => 'required|string',
            'attributes.recommended_age_group' => 'required|string',
        ]);

        $accessToken = $this->mercadoLivreService->someApiCall();

        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('uploads', 'public');
         
            $imagemUrl = secure_asset('storage/' . $imagePath);
        } else {
            return back()->withErrors(['imagem' => 'Erro ao fazer o upload da imagem']);
        }

        $response = Http::withToken($accessToken)
            ->post(env('MERCADO_LIVRE_API_URL') . '/items', [
                'title' => $request->nome,
                'category_id' => $request->categoria,
                'listing_type_id' => 'gold_special',
                'price' => $request->preco,
                'currency_id' => 'BRL',
                'available_quantity' => $request->qtd_estoque,
                'condition' => 'new',
                'pictures' => [
                    ['source' => $imagemUrl],
                ],
                'description' => $request->desc,
                'shipping' => [
                    'mode' => 'me2',
                    'local_pick_up' => false,
                    'free_shipping' => true,
                    'logistic_type' => 'drop_off',
                    'dimensions' => '10x10x20,500'
                ],
                'attributes' => [
                    ['id' => 'BRAND', 'value_name' => $request->input('attributes.brand')],
                    ['id' => 'MODEL', 'value_name' => $request->input('attributes.model')],
                    ['id' => 'RECOMMENDED_AGE_GROUP', 'value_name' => $request->input('attributes.recommended_age_group')],
                ],
            ]);

        if ($response->successful()) {

            Produtos::create([
                'idProduto' => $response['id'],
                'nome' => $request->nome,
                'desc' => $request->desc,
                'preco' => $request->preco,
                'qtd_estoque' => $request->qtd_estoque,
                'categoria' => $request->categoria,
                'imagem' => $imagemUrl ?? null,
            ]);

            return back()->with('success', 'Produto cadastrado com sucesso no Mercado Livre!');
        } else {
            //dd($response->status(), $response->body());
            return back()->with('error', 'Erro ao cadastrar o produto: ' . $response->body());
        }
    }

    public function index()
    {
        $accessToken = $this->mercadoLivreService->someApiCall();
        $response = $this->mercadoLivreService->getUserProducts(session('ID'));

        if ($response->successful()) {
            $produtos = $response->json()['results'];
            
            $produtosNoBanco = Produtos::whereIn('idProduto', $produtos)->get();
            return view('index', compact('produtosNoBanco')); 
        }

        return redirect()->back()->withErrors('Erro ao buscar produtos: ' . $response->status());
    }
}
