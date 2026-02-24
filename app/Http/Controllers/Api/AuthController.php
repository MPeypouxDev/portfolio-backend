<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Connexion et génération du token JWT
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (! $token = auth('api')->attempt($credentials)) {
            Log::warning('Tentative de connexion échouée', [
                'email' => $request->input('email'),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            abort(401, 'Identifiants incorrects');
        }

        return $this->respondWithToken($token);
    }

    /**
     * Récupérer l'utilisateur connecté
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Déconnexion (invalider le token)
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Déconnexion réussie']);
    }

    /**
     * Rafraîchir le token
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Formater la réponse avec le token
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
        ]);
    }
}
