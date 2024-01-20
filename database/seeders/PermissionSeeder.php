<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin_role = Role::where('slug', 'admin')->first();
        $developer_role = Role::where('slug', 'developer')->first();

        $permissions = [
            'restaurant' => ['Access Restaurant', 'Create Restaurant', 'Edit Restaurant', 'Delete Restaurant'],
            'menu' => ['Access Menu', 'Create Menu', 'Edit Menu', 'Delete Menu'],
            'category' => ['Access Category', 'Create Category', 'Edit Category', 'Delete Category'],

            'role' => ['Access role', 'Create role', 'Edit role', 'Delete role'],
            'staff' => ['Access Staff', 'Create Staff', 'Edit Staff', 'Delete Staff'],
        ];

        foreach ($permissions as $index => $perm) {
            foreach ($perm as $name) {
                $permission = Permission::create([
                    'slug' => Str::slug($name),
                    'name' => $name,
                    'type' => $index
                ]);

                $admin_role->permissions()->attach($permission->id);
                $developer_role->permissions()->attach($permission->id);
            }
        }
    }
}
