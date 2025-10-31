<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        //  Create Permissions
        $permissions = [
            'manage schools',
            'manage teachers',
            'manage students',
            'upload school data',
            'set work',
            'view progress',
            'take test',
            'view course content',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Roles
        $roles = [
            'admin',
            'teacher_manager',
            'teacher',
            'cover_supervisor',
            'student',
            'subscriber',
            'demo',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        // Assign Permissions to Roles
        $admin = Role::findByName('admin');
        $admin->givePermissionTo(Permission::all());

        $teacherManager = Role::findByName('teacher_manager');
        $teacherManager->givePermissionTo(['set work', 'view progress', 'manage students']);

        $teacher = Role::findByName('teacher');
        $teacher->givePermissionTo(['set work', 'view progress']);

        $cover = Role::findByName('cover_supervisor');
        $cover->givePermissionTo(['view progress']);

        $student = Role::findByName('student');
        $student->givePermissionTo(['take test', 'view course content']);

        $subscriber = Role::findByName('subscriber');
        $subscriber->givePermissionTo(['view course content']);

        $demo = Role::findByName('demo');
        $demo->givePermissionTo(['set work', 'view progress']);
    }
}
