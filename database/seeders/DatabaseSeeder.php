<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    private $permissions = [
        'role-list',
        'role-create',
        'role-edit',
        'role-delete',
        'product-list',
        'product-create',
        'product-edit',
        'product-delete',
        'user-list',
        'user-create',
        'user-edit',
        'user-delete',
    ];
    public function run(): void
    {
        foreach ($this->permissions as $permission){
            Permission::create(['name'=>$permission]);
        }
        $user = User::create([
            'name'=>'shahzod',
            'email'=>'shahzodrashidov0307@gmail.com',
            'password'=>Hash::make('admin123'),
        ]);
        $role = Role::create(['name'=>'admin']);
        $role_user = Role::create(['name'=>'user']);
        $permissions = Permission::pluck('id','id')->all();
        $permission_user = Permission::whereIn('name', ['product-list', 'user-list'])->get();

        $role->syncPermissions($permissions);
        $role_user->syncPermissions($permission_user);
        $user->assignRole([$role->id]);
    }
}
