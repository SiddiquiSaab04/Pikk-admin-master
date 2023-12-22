<?php

namespace Modules\Permissions\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Modules\Permissions\app\Models\Permission;
use Modules\Role\app\Models\Role;
use Exception;

class PermissionsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $permissions = [
                [
                    'name' => "create_users"
                ],
                [
                    'name' => "read_users"
                ],
                [
                    'name' => "update_users"
                ],
                [
                    'name' => "delete_users"
                ],
                [
                    'name' => "create_branches"
                ],
                [
                    'name' => "read_branches"
                ],
                [
                    'name' => "update_branches"
                ],
                [
                    'name' => "delete_branches"
                ],
                [
                    'name' => "create_roles"
                ],
                [
                    'name' => "read_roles"
                ],
                [
                    'name' => "update_roles"
                ],
                [
                    'name' => "delete_roles"
                ],
                [
                    'name' => "create_permissions"
                ],
                [
                    'name' => "read_permissions"
                ],
                [
                    'name' => "update_permissions"
                ],
                [
                    'name' => "delete_permissions"
                ],
                [
                    'name' => "create_products"
                ],
                [
                    'name' => "read_products"
                ],
                [
                    'name' => "update_products"
                ],
                [
                    'name' => "delete_products"
                ],
                [
                    'name' => "create_medias"
                ],
                [
                    'name' => "read_medias"
                ],
                [
                    'name' => "update_medias"
                ],
                [
                    'name' => "delete_medias"
                ],
                [
                    'name' => "create_categories"
                ],
                [
                    'name' => "read_categories"
                ],
                [
                    'name' => "update_categories"
                ],
                [
                    'name' => "delete_categories"
                ],
                [
                    'name' => "create_addons"
                ],
                [
                    'name' => "read_addons"
                ],
                [
                    'name' => "update_addons"
                ],
                [
                    'name' => "delete_addons"
                ],
                [
                    'name' => "create_addon_groups"
                ],
                [
                    'name' => "read_addon_groups"
                ],
                [
                    'name' => "update_addon_groups"
                ],
                [
                    'name' => "delete_addon_groups"
                ],
                [
                    'name' => "create_units"
                ],
                [
                    'name' => "read_units"
                ],
                [
                    'name' => "update_units"
                ],
                [
                    'name' => "delete_units"
                ],
                [
                    'name' => "create_unit_groups"
                ],
                [
                    'name' => "read_unit_groups"
                ],
                [
                    'name' => "update_unit_groups"
                ],
                [
                    'name' => "delete_unit_groups"
                ],
                [
                    'name' => "manage_settings"
                ],
                [
                    'name' => "see_reports"
                ],
                [
                    'name' => "pos"
                ],
                [
                    'name' => "kds"
                ]
            ];

            try {

                collect($permissions)->each(function ($permission) {
                    Permission::updateOrCreate([
                        'name' => $permission['name']
                    ], $permission);
                });

                $superAdminRole = Role::where('name', 'super_admin')->first();
                $allPermissions = Permission::all()->except(['pos', 'kds']);
                $superAdminRole->syncPermissions($allPermissions);

                $adminRole = Role::where('name', 'admin')->first();
                $manageRole = Role::where('name', 'manager')->first();

                $readingPermissions = Permission::whereIn('name', ['create_users', 'read_users', 'update_users', 'delete_users', 'read_roles', 'read_permissions', 'read_products', 'read_medias', 'read_categories', 'read_addons', 'read_addon_groups', 'read_units', 'read_unit_groups', 'see_reports', 'pos', 'kds'])->get();

                $adminRole->syncPermissions($readingPermissions);
                $manageRole->syncPermissions($readingPermissions);

                $staffRole = Role::where('name', 'staff')->first();
                $posPermission = Permission::whereIn('name', ['pos'])->get();
                $staffRole->syncPermissions($posPermission);

                $chefRole = Role::where('name', 'chef')->first();
                $kdsPermissions = Permission::whereIn('name', ['kds'])->get();
                $chefRole->syncPermissions($kdsPermissions);
            } catch (Exception $e) {
                Log::info($e->getMessage());
            }
        }
    }
}
