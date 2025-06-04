<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\RolesEnum;
use Illuminate\Support\Str;

class UserWithRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = Role::create(['name' => RolesEnum::ADMIN->value]);
        $admin_user =  User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
        ]);
        $admin_user->assignRole($admin_role);

        $employee_role = Role::create(['name' => RolesEnum::EMPLOYEE->value]);
        $employee_user =  User::factory()->create([
            'name' => 'Employee',
            'email' => 'employee@mail.com',
        ]);
        $employee_user->assignRole($employee_role);
    }
}
