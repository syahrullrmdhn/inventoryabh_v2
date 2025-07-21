<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        // User default
        User::create([
            'name'     => 'Syahrul',
            'email'    => 'syahrul@abhinawa.co.id',
            'password' => Hash::make('syahrul123'),
        ]);

        // Jika ada seeder lain, panggil di sini…
    }
}
