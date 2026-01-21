<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Connexion et génération du token JWT
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $request->only('email', 'password');

        if (!$token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Identifiants incorrects'], 401);
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
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }
}
