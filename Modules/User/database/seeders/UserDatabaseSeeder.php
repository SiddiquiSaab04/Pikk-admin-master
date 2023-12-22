<?php

namespace Modules\User\database\seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $user = new User();
            $user->name = "Super Admin Pikk";
            $user->email = "super.admin@pikk.com";
            $user->password = Hash::make("123asd123");
            $user->status = 1;
            $user->save();

            $user->assignRole('super_admin');
           
        } catch (Exception $e) {
            
        }
    }
}
