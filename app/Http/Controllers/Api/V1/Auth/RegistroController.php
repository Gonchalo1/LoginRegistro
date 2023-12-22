<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Models\User; // Agregado para usar el modelo User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\validation\rules\Password; // Agregado para usar Password::defaults()
use Illuminate\Http\Response; // Agregado para usar la constante Response::HTTP_CREATED


/*
* @group Auth
*
*/
class RegistroController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $device = substr($request->userAgent() ?? '', 0, 255);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        return response()->json([
            'access_token' => $user->createToken($device)->plainTextToken,
        ], Response::HTTP_CREATED);
    }
}

