<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $resources = [
            'leads' => 'Leads',
            'users' => 'Users',
            'sale_users' => 'Sale Users',
            'showrooms' => 'Showrooms',
            'provinces' => 'Provinces',
            'customer_statuses' => 'Customer Statuses',
            'customer_types' => 'Customer Types',
            'product_categories' => 'Product Categories',
            'customer_sources' => 'Customer Sources',
            'roles' => 'Roles',
            'permissions' => 'Permissions',
        ];

        $actions = [
            'view-any' => 'Xem danh sách',
            'view' => 'Xem chi tiết',
            'create' => 'Tạo mới',
            'update' => 'Cập nhật',
            'delete' => 'Xóa',
            'manage' => 'Quản lý toàn bộ',
        ];

        $permissions = [];

        // Tạo permissions cho từng resource và action
        foreach ($resources as $resourceSlug => $resourceName) {
            foreach ($actions as $actionSlug => $actionName) {
                $permissions[] = [
                    'name' => $actionName . ' ' . $resourceName,
                    'slug' => $resourceSlug . '.' . $actionSlug,
                    'description' => 'Cho phép ' . strtolower($actionName) . ' ' . strtolower($resourceName),
                ];
            }
        }

        foreach ($permissions as $permission) {
            Permission::updateOrCreate($permission);
        }
    }
}

