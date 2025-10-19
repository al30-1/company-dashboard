<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    // Get company IDs
    $acme = \App\Models\Company::where('code', 'ACME')->first()->id;
    $beta = \App\Models\Company::where('code', 'BETA')->first()->id;
    $gamma = \App\Models\Company::where('code', 'GAMMA')->first()->id;

    \App\Models\User::create([
        'name' => 'Alice Admin',
        'username' => 'alice',
        'email' => 'alice@acme.com',
        'password' => bcrypt('Passw0rd!'),
        'full_name' => 'Alice Johnson',
        'company_id' => $acme,
        'is_active' => true,
    ]);

    \App\Models\User::create([
        'name' => 'Bob User',
        'username' => 'bob',
        'email' => 'bob@beta.com',
        'password' => bcrypt('Passw0rd!'),
        'full_name' => 'Bob Smith',
        'company_id' => $beta,
        'is_active' => true,
    ]);

    // Add remaining users the same way (one by one with create())
    \App\Models\User::create([
        'name' => 'Charlie Gamma',
        'username' => 'charlie',
        'email' => 'charlie@gamma.com',
        'password' => bcrypt('Passw0rd!'),
        'full_name' => 'Charlie Brown',
        'company_id' => $gamma,
        'is_active' => true,
    ]);

    \App\Models\User::create([
        'name' => 'Diana ACME',
        'username' => 'diana',
        'email' => 'diana@acme.com',
        'password' => bcrypt('Passw0rd!'),
        'full_name' => 'Diana Prince',
        'company_id' => $acme,
        'is_active' => true,
    ]);

    \App\Models\User::create([
        'name' => 'Eve BETA',
        'username' => 'eve',
        'email' => 'eve@beta.com',
        'password' => bcrypt('Passw0rd!'),
        'full_name' => 'Eve Adams',
        'company_id' => $beta,
        'is_active' => true,
    ]);

    \App\Models\User::create([
        'name' => 'Frank GAMMA',
        'username' => 'frank',
        'email' => 'frank@gamma.com',
        'password' => bcrypt('Passw0rd!'),
        'full_name' => 'Frank Miller',
        'company_id' => $gamma,
        'is_active' => true,
    ]);

    \App\Models\User::create([
        'name' => 'Grace ACME',
        'username' => 'grace',
        'email' => 'grace@acme.com',
        'password' => bcrypt('Passw0rd!'),
        'full_name' => 'Grace Hopper',
        'company_id' => $acme,
        'is_active' => true,
    ]);

    \App\Models\User::create([
        'name' => 'Henry BETA',
        'username' => 'henry',
        'email' => 'henry@beta.com',
        'password' => bcrypt('Passw0rd!'),
        'full_name' => 'Henry Ford',
        'company_id' => $beta,
        'is_active' => true,
    ]);
}
}
