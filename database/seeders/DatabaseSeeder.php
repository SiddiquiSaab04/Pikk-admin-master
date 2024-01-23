<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Permissions\database\seeders\PermissionsDatabaseSeeder;
use Modules\Role\database\seeders\RoleDatabaseSeeder;
use Modules\Settings\database\seeders\SettingsDatabaseSeeder;
use Modules\User\database\seeders\UserDatabaseSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleDatabaseSeeder::class,
            UserDatabaseSeeder::class,
            PermissionsDatabaseSeeder::class,
            SettingsDatabaseSeeder::class
        ]);
    }
}
