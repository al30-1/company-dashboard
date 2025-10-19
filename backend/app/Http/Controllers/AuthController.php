<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'invalid'], 401);
        }

        $company = Company::where('code', $request->company_code)->first();

        $token = $user->createToken('webtoken')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
            'company' => $company
        ]);
    }
}