<?php

namespace App\Services;

use App\Models\MercadoLivreToken;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class MercadoLivreService
{

    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->clientId = env('APP_ID');
        $this->clientSecret = env('CLIENT_SECRET');
    }

    public function isTokenExpired()
    {
    $tokenData = DB::table('mercado_livre_tokens')->where('id', session('ID'))->first();

    if ($tokenData && $tokenData->expires_at) {
        return now()->greaterThan($tokenData->expires_at);
    }

    return true;
    }

    public function refreshAccessToken($refreshToken)
    {
        $response = Http::asForm()->post('https://api.mercadolibre.com/oauth/token', [
            'grant_type' => 'refresh_token',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'refresh_token' => $refreshToken,
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $expiresIn = $data['expires_in'];

            $expirationTime = now()->addSeconds($expiresIn);

            DB::table('mercado_livre_tokens')
            ->where('id', session('ID'))
            ->update(
                [
                    'access_token' => $data['access_token'],
                    'refresh_token' => $data['refresh_token'],
                    'expires_at' => $expirationTime,
                ]
            );

            return $data['access_token'];
        }

        throw new \Exception('Erro ao fazer refresh do token.');
    }

    public function someApiCall()
    {
        if ($this->isTokenExpired()) {
            
            $refreshToken = DB::table('mercado_livre_tokens')->where('id', session('ID'))->value('refresh_token');
            $newAccessToken = $this->refreshAccessToken($refreshToken);

            if (!$newAccessToken) {
                return redirect('/refresh');
            }
        }

        $accessToken = DB::table('mercado_livre_tokens')->where('id', session('ID'))->value('access_token');
        session('mercadolivre_token', $accessToken);
        $response = $accessToken;
        
        return $response;
    }

    public function getUserProducts($userId)
    {
        $accessToken = $this->someApiCall();
        
        return Http::withToken($accessToken)
            ->get(env('MERCADO_LIVRE_API_URL') . "/users/{$userId}/items/search");
    }
}

