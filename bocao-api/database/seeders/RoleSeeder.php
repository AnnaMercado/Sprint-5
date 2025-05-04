<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    // Crea el rol "user" con el guard "api"
    Role::firstOrCreate(['name' => 'user', 'guard_name' => 'api']);
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);

    Permission::firstOrCreate(['name' => 'read users']);

    // Puedes agregar más roles si los necesitas:
    // Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'api']);
}

}