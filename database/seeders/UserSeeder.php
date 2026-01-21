<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Mathys Peypoux',
            'email' => 'admin@portfolio.com',
            'password' => Hash::make('001129SYHTAMfoot**'),
        ]);
    }
}
