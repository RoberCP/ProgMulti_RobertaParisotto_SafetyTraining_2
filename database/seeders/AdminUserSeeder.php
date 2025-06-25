<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Roberta Admin',
            'email' => '193872@upf.br',
            'password' => Hash::make('senha123'),
            'is_admin' => true,
        ]);
    }
    

}
