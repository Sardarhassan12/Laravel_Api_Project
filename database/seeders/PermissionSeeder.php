<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'create task',
            'update task',
            'view task',
            'delete task',
            'import task',
            'export task',
            'generate pdf'
        ];

        foreach($permissions as $permission){
            Permission::firstOrCreate(['name' => $permission]);
        }

        $subscribedUserRole = Role::firstOrCreate(['name' => 'Subscribed User']);
        $subscribedUserRole->givePermissionTo(Permission::all());

        $unsubscribedUserRole = Role::firstOrCreate(['name' => 'Unsubscribed User']);
        $unsubscribedUserRole->givePermissionTo(['create task', 'update task', 'view task', 'delete task']);
    }
}
