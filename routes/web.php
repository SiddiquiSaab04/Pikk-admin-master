<?php

use App\Http\Controllers\SetupController;
use App\Http\Middleware\InstalledStateMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;
use Modules\Inventory\app\Models\Product;
use Modules\Inventory\app\Models\ProductStock;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('hello', function() {
    $products = Product::get();
    foreach($products as $product) {
        $stock = DB::table('product_stocks_6')->insert([
            "product_id" => $product->id,
            "is_enabled" => 1,
            "available_stock" => 50,
            "default_quantity" => 50,
            "is_new" => 1,
        ]);
    }
    return 'success';
});

Route::get('do-setup', [SetupController::class, 'welcome'])->name('do-setup');

Route::middleware(['auth'])->group(function() {
    Route::get('/', function () {
        return view('index');
    })->name('home');
});

Auth::routes();

Route::get('/test', function () {
    return 'succes';
    $products = Product::get();
    $stock = DB::table('product_stocks_6')->get();
    dd($stock);
    foreach($products as $product) {
    }
    // Reset cached roles and permissions
    // app()[PermissionRegistrar::class]->forgetCachedPermissions();

    // create permissions

    // Users
    // Permission::create(['name' => 'create users']);
    // Permission::create(['name' => 'read users']);
    // Permission::create(['name' => 'update users']);
    // Permission::create(['name' => 'delete users']);
    // Customers
    // Permission::create(['name' => 'create customers']);
    // Permission::create(['name' => 'read customers']);
    // Permission::create(['name' => 'update customers']);
    // Permission::create(['name' => 'delete customers']);

    // Products
    // Permission::create(['name' => 'create products']);
    // Permission::create(['name' => 'read products']);
    // Permission::create(['name' => 'update products']);
    // Permission::create(['name' => 'delete products']);

    // Medias
    // Permission::create(['name' => 'create medias']);
    // Permission::create(['name' => 'read medias']);
    // Permission::create(['name' => 'update medias']);
    // Permission::create(['name' => 'delete medias']);
    // Reports
    // Permission::create(['name' => 'read reports']);

    // Roles
    // $superAdminRole = Role::create(['name' => 'super-admin']);
    // $adminRole = Role::create(['name' => 'admin']);
    // $chefRole = Role::create(['name' => 'chef']);
    // $staffRole = Role::create(['name' => 'staff']);
    // $managerRole = Role::create(['name' => 'manager']);

    // Role Assignments
    // $superAdminRole->givePermissionTo(['read users', 'read customers', 'read products', 'read medias', 'read reports']);

    // $adminRole->givePermissionTo(['create users','read users','update users','delete users']);
    // $adminRole->givePermissionTo(['create customers','read customers','update customers','delete customers']);
    // $adminRole->givePermissionTo(['create products','read products','update products','delete products']);
    // $adminRole->givePermissionTo(['create medias','read medias','update medias','delete medias']);
    // $adminRole->givePermissionTo('read reports');

    // Create user and assiging role
    // $superAdminUser = \App\Models\User::factory()->create([
    //     'name' => 'Super Admin',
    //     'email' => 'super-admin@pikk.com',
    //     'password' => Hash::make('admin'),
    // ]);

    // $superAdminUser->assignRole($superAdminRole);


    // $adminUser = \App\Models\User::factory()->create([
    //     'name' => 'Admin',
    //     'email' => 'admin@pikk.com',
    //     'password' => Hash::make('admin'),

    // ]);

    // $adminUser->assignRole($adminRole);

    return 'Success';
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
