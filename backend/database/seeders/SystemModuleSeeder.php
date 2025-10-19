<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Create Systems
    $admin = \App\Models\System::create(['name' => 'Admin', 'code' => 'ADMIN']);
    $ops = \App\Models\System::create(['name' => 'Operations', 'code' => 'OPS']);

    // Modules for Admin System
    $userMgmt = \App\Models\Module::create(['system_id' => $admin->id, 'name' => 'User Management', 'code' => 'USER_MGMT', 'icon' => 'users']);
    $roleMgmt = \App\Models\Module::create(['system_id' => $admin->id, 'name' => 'Role Management', 'code' => 'ROLE_MGMT', 'icon' => 'shield']);
    $audit = \App\Models\Module::create(['system_id' => $admin->id, 'name' => 'Audit Logs', 'code' => 'AUDIT', 'icon' => 'file-text']);

    // Modules for Operations System
    $inventory = \App\Models\Module::create(['system_id' => $ops->id, 'name' => 'Inventory', 'code' => 'INVENTORY', 'icon' => 'box']);
    $orders = \App\Models\Module::create(['system_id' => $ops->id, 'name' => 'Orders', 'code' => 'ORDERS', 'icon' => 'shopping-cart']);
    $reports = \App\Models\Module::create(['system_id' => $ops->id, 'name' => 'Reports', 'code' => 'REPORTS', 'icon' => 'bar-chart']);

    // Submodules for User Management
    \App\Models\Submodule::create(['module_id' => $userMgmt->id, 'name' => 'Users List', 'code' => 'USERS_LIST', 'route' => '/admin/users']);
    \App\Models\Submodule::create(['module_id' => $userMgmt->id, 'name' => 'Create User', 'code' => 'CREATE_USER', 'route' => '/admin/users/create']);
    \App\Models\Submodule::create(['module_id' => $userMgmt->id, 'name' => 'User Groups', 'code' => 'USER_GROUPS', 'route' => '/admin/groups']);

    // Submodules for Role Management
    \App\Models\Submodule::create(['module_id' => $roleMgmt->id, 'name' => 'Roles', 'code' => 'ROLES', 'route' => '/admin/roles']);
    \App\Models\Submodule::create(['module_id' => $roleMgmt->id, 'name' => 'Permissions', 'code' => 'PERMISSIONS', 'route' => '/admin/permissions']);

    // Submodules for Audit Logs
    \App\Models\Submodule::create(['module_id' => $audit->id, 'name' => 'Login History', 'code' => 'LOGIN_HISTORY', 'route' => '/admin/audit/login']);
    \App\Models\Submodule::create(['module_id' => $audit->id, 'name' => 'Activity Log', 'code' => 'ACTIVITY_LOG', 'route' => '/admin/audit/activity']);

    // Submodules for Inventory
    \App\Models\Submodule::create(['module_id' => $inventory->id, 'name' => 'Products', 'code' => 'PRODUCTS', 'route' => '/ops/inventory/products']);
    \App\Models\Submodule::create(['module_id' => $inventory->id, 'name' => 'Warehouses', 'code' => 'WAREHOUSES', 'route' => '/ops/inventory/warehouses']);

    // Submodules for Orders
    \App\Models\Submodule::create(['module_id' => $orders->id, 'name' => 'Order List', 'code' => 'ORDER_LIST', 'route' => '/ops/orders']);
    \App\Models\Submodule::create(['module_id' => $orders->id, 'name' => 'Create Order', 'code' => 'CREATE_ORDER', 'route' => '/ops/orders/create']);
    \App\Models\Submodule::create(['module_id' => $orders->id, 'name' => 'Order Status', 'code' => 'ORDER_STATUS', 'route' => '/ops/orders/status']);

    // Submodules for Reports
    \App\Models\Submodule::create(['module_id' => $reports->id, 'name' => 'Sales Report', 'code' => 'SALES_REPORT', 'route' => '/ops/reports/sales']);
    \App\Models\Submodule::create(['module_id' => $reports->id, 'name' => 'Inventory Report', 'code' => 'INVENTORY_REPORT', 'route' => '/ops/reports/inventory']);
}
}
