<?php

namespace Modules\Role\database\seeders;

use Illuminate\Database\Seeder;
use Modules\Role\app\Models\Role;
use Illuminate\Support\Facades\Log;
use Exception;


class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => "super_admin"
            ],
            [
                'name' => "admin"
            ],
            [
                'name' => "manager"
            ],
            [
                'name' => "staff"
            ],
            [
                'name' => "chef"
            ]
        ];

        try {

            collect($roles)->each(function ($roles) {
                Role::updateOrCreate([
                    'name' => $roles['name']
                ], $roles);
            });
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }
}
