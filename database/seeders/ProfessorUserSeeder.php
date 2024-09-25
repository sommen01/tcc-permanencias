<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfessorUserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Professor Teste',
            'email' => 'professor123@ifms.edu.br',
            'password' => Hash::make('senha123'),
            'role' => 'professor',
        ]);
    }
}