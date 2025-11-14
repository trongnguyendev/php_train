<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Quản trị viên hệ thống với tất cả quyền',
            ],
            [
                'name' => 'Manager',
                'slug' => 'manager',
                'description' => 'Quản lý với quyền quản lý các module chính',
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Nhân viên với quyền xem và tạo dữ liệu',
            ],
            [
                'name' => 'Sale',
                'slug' => 'sale',
                'description' => 'Nhân viên bán hàng với quyền quản lý leads',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate($role);
        }
    }
}

