<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Company;

Route::post('/test-login', function () {
    $user = User::where('username', 'alice')->first();
    if (!$user) {
        return response()->json(['error' => 'User not found'], 404);
    }
    if (!Hash::check('Passw0rd!', $user->password)) {
        return response()->json(['error' => 'Password mismatch'], 401);
    }
    $company = Company::where('code', 'ACME')->first();
    if (!$company) {
        return response()->json(['error' => 'Company not found'], 404);
    }
    return response()->json([
        'message' => 'SUCCESS: Credentials are valid',
        'user' => $user->username,
        'company' => $company->name
    ]);
});
