<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo hoặc lấy role admin
        $adminRole = Role::updateOrCreate(
            ['slug' => 'admin'],
            [
                'name' => 'Administrator',
                'description' => 'Quản trị viên hệ thống với tất cả quyền',
            ]
        );

        // Lấy tất cả permissions liên quan đến users, roles, permissions
        $adminPermissions = Permission::where(function($query) {
            $query->where('slug', 'like', 'users.%')
                  ->orWhere('slug', 'like', 'roles.%')
                  ->orWhere('slug', 'like', 'leads.%')
                  ->orWhere('slug', 'like', 'sale_users.%')
                  ->orWhere('slug', 'like', 'showrooms.%')
                  ->orWhere('slug', 'like', 'provinces.%')
                  ->orWhere('slug', 'like', 'support-channels.%')
                  ->orWhere('slug', 'like', 'customer_statuses.%')
                  ->orWhere('slug', 'like', 'customer_types.%')
                  ->orWhere('slug', 'like', 'product_categories.%')
                  ->orWhere('slug', 'like', 'customer_sources.%')
                  ->orWhere('slug', 'like', 'permissions.%')
                  ->orWhere('slug', 'like', 'report_daily.%')
                  ->orWhere('slug', 'like', 'report_month.%')
                  ->orWhere('slug', 'like', 'report_showroom.%')
                  ->orWhere('slug', 'like', 'potential.%');
                  
        })->get();

        // Gán các permissions này cho role admin
        $adminRole->permissions()->sync($adminPermissions->pluck('id'));

        // Tạo user admin
        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'), // Mật khẩu mặc định: password
            ]
        );

        // Gán role admin cho user
        $adminUser->roles()->sync([$adminRole->id]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
        $this->command->info('Role: Administrator (with all permissions)');
    }
}

