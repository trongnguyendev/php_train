<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Tạo user admin mặc định
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Tạo một số user mẫu
        User::create([
            'name' => 'Nguyễn Văn A',
            'email' => 'nguyenvana@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Trần Thị B',
            'email' => 'tranthib@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Lê Văn C',
            'email' => 'levanc@example.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => now(),
        ]);

        // Tạo thêm user ngẫu nhiên
        User::factory(10)->create();
    }
}
