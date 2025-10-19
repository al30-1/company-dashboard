<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Fetch users
    $alice = \App\Models\User::where('username', 'alice')->first();
    $bob = \App\Models\User::where('username', 'bob')->first();
    $charlie = \App\Models\User::where('username', 'charlie')->first();
    $diana = \App\Models\User::where('username', 'diana')->first();

    // Fetch submodules by code (safe and clear)
    $adminSubmodules = \App\Models\Submodule::whereIn('code', [
        'USERS_LIST', 'CREATE_USER', 'USER_GROUPS',
        'ROLES', 'PERMISSIONS',
        'LOGIN_HISTORY', 'ACTIVITY_LOG'
    ])->pluck('id');

    $opsSubmodules = \App\Models\Submodule::whereIn('code', [
        'PRODUCTS', 'WAREHOUSES',
        'ORDER_LIST', 'CREATE_ORDER', 'ORDER_STATUS',
        'SALES_REPORT', 'INVENTORY_REPORT'
    ])->pluck('id');

    // Alice: full Admin access
    foreach ($adminSubmodules as $subId) {
        \App\Models\UserSubmodule::create([
            'user_id' => $alice->id,
            'submodule_id' => $subId,
            'granted_at' => now(),
            'created_by' => $alice->id, // self-granted for demo
        ]);
    }

    // Bob: full Operations access
    foreach ($opsSubmodules as $subId) {
        \App\Models\UserSubmodule::create([
            'user_id' => $bob->id,
            'submodule_id' => $subId,
            'granted_at' => now(),
            'created_by' => $alice->id, // granted by admin
        ]);
    }

    // Charlie (GAMMA): only Reports + Inventory
    $charlieSubs = \App\Models\Submodule::whereIn('code', [
        'PRODUCTS', 'WAREHOUSES',
        'SALES_REPORT', 'INVENTORY_REPORT'
    ])->pluck('id');

    foreach ($charlieSubs as $subId) {
        \App\Models\UserSubmodule::create([
            'user_id' => $charlie->id,
            'submodule_id' => $subId,
            'granted_at' => now(),
            'created_by' => $alice->id,
        ]);
    }

    // Diana (ACME): only User Management
    $dianaSubs = \App\Models\Submodule::whereIn('code', [
        'USERS_LIST', 'CREATE_USER'
    ])->pluck('id');

    foreach ($dianaSubs as $subId) {
        \App\Models\UserSubmodule::create([
            'user_id' => $diana->id,
            'submodule_id' => $subId,
            'granted_at' => now(),
            'created_by' => $alice->id,
        ]);
    }
}
}
