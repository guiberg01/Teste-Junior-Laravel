<?php
use App\Services\MercadoLivreService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MercadoLivreController;

use App\Http\Controllers\ProdutoController;

Route::middleware(['web'])->group(function () {

    Route::get('/produtos/index', [ProdutoController::class, 'index'])->name('produtos.index');
    Route::get('/produtos/create', [ProdutoController::class, 'create'])->name('produtos.create');
    Route::post('/produtos/store', [ProdutoController::class, 'store'])->name('produtos.store');

    Route::get('/', function (){
        if(!empty(session('ID'))){
            return redirect('/perfil');
        }
        return view('main');
    });

    Route::get('/login', function () {
        $clientId = env('APP_ID');
        $redirectUri = env('REDIRECT_URI');
        $authUrl = "https://auth.mercadolivre.com.br/authorization?response_type=code&client_id={$clientId}&redirect_uri={$redirectUri}";

        return redirect($authUrl);
    });

    Route::get('/callback', function (\Illuminate\Http\Request $request) {

        $code = $request->query('code');

        if (!$code) {
            return 'Erro na autenticação.';
        }

        $response = Http::post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => env('APP_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'code' => $code,
            'redirect_uri' => env('REDIRECT_URI'),
        ]);

        $data = $response->json();
        $expiresIn = $data['expires_in'];

        session(['mercadolivre_token' => $data['access_token']]);
        session(['ID' => $data['user_id']]);
        session(['dataLogin' => now()]);

        $expirationTime = now()->addSeconds($expiresIn);

        DB::table('mercado_livre_tokens')->updateOrInsert(
            ['id' => session('ID')],
            [
                'id' => $data['user_id'],
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'expires_at' => $expirationTime,
            ]
        );

        return redirect('/perfil');
    });

    Route::get('/perfil', function (MercadoLivreService $mercadoLivreService) {
        $token = $mercadoLivreService->someApiCall();

        if (!$token) {
            return redirect('/login');
        }

        $response = Http::withToken($token)->get('https://api.mercadolibre.com/users/me');

        $responseData = json_decode($response->getBody()->getContents(), true);
        $filteredData = [];

        if (isset($responseData)) {
            $filteredData['nome'] = $responseData['first_name'] ?? null;
            $filteredData['registration_date'] = session('dataLogin') ?? null;
        }
        return view('perfil', ['responseData' => $filteredData]);
    });

    Route::get('/refresh', function () {
        $refreshToken = DB::table('mercado_livre_tokens')->where('id', session('ID'))->value('refresh_token');

        $response = Http::post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'refresh_token',
            'client_id' => env('APP_ID'),
            'client_secret' => env('CLIENT_SECRET'),
            'refresh_token' => $refreshToken,
        ]);

        $data = $response->json();

        session([
            'mercadolivre_token' => $data['access_token'],
            'mercadolivre_refresh_token' => $data['refresh_token']
        ]);

        return 'Token atualizado!';
    });
});