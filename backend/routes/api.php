<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Company;
use App\Models\System;

// Public routes
Route::get('/companies', function () {
    return Company::select('id', 'name', 'code', 'primary_color', 'accent_color')->get();
});

Route::post('/login', function (Request $request) {
    \Log::info('Login attempt:', $request->all());
    
    $user = User::where('username', $request->username)->first();
    
    if (!$user) {
        \Log::error('User not found: ' . $request->username);
        return response()->json(['error' => 'User not found'], 401);
    }
    
    if (!Hash::check($request->password, $user->password)) {
        \Log::error('Password mismatch for user: ' . $request->username);
        return response()->json(['error' => 'Invalid password'], 401);
    }
    
    $company = Company::where('code', $request->company_code)->first();
    
    if (!$company) {
        \Log::error('Company not found: ' . $request->company_code);
        return response()->json(['error' => 'Invalid company code'], 400);
    }
    
    try {
        $token = $user->createToken('webtoken')->plainTextToken;
        \Log::info('Login successful for: ' . $user->username);
        
        return response()->json([
            'token' => $token,
            'user' => $user,
            'company' => $company
        ]);
    } catch (\Exception $e) {
        \Log::error('Token creation failed: ' . $e->getMessage());
        return response()->json(['error' => 'Token creation failed'], 500);
    }
});

// Protected routes (require authentication)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return response()->json($request->user());
    });
    
    Route::get('/modules', function (Request $request) {
        $user = $request->user();
        
        // Load systems with modules and permission-filtered submodules (Section 5.5)
        $systems = System::with(['modules.submodules' => function ($query) use ($user) {
            $query->whereIn('id', $user->submodules->pluck('id'));
        }])->get();
        
        // Format according to Section 4.3
        $formatted = $systems->map(function ($system) {
            return [
                'system_id' => $system->id,
                'system_name' => $system->name,
                'modules' => $system->modules->map(function ($module) {
                    return [
                        'module_id' => $module->id,
                        'module_name' => $module->name,
                        'submodules' => $module->submodules->map(function ($sub) {
                            return [
                                'id' => $sub->id,
                                'name' => $sub->name,
                                'route' => $sub->route,
                            ];
                        })->values()
                    ];
                })->values()
            ];
        })->values();
        
        return response()->json($formatted);
    });
});