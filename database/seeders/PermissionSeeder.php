<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat role jika belum ada
        $role_admin = Role::updateOrCreate(['name' => 'admin']);
        $role_bidan = Role::updateOrCreate(['name' => 'bidan']);
        $role_pemdes = Role::updateOrCreate(['name' => 'pemdes']);
        $role_kader = Role::updateOrCreate(['name' => 'kader']);
        $role_ortu = Role::updateOrCreate(['name' => 'ortu']);

        // Membuat permissions
        $permissions = [
            'create-post',
            'edit-post',
            'delete-post',
            'view-post',
            'manage-users',
        ];

        // Menambahkan permissions
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission]);
        }

        // Memberikan permission pada roles
        // Admin diberi semua permissions
        $role_admin->givePermissionTo(['view-post', 'edit-post' , 'delete-post', 'create-post']);

        // Menentukan permissions khusus untuk role tertentu
        $role_bidan->givePermissionTo(['view-post',]); // Misalnya, bidan hanya bisa melihat dan membuat post
        $role_kader->givePermissionTo(['view-post', 'edit-post' , 'delete-post', 'create-post']); // Kader hanya bisa melihat
        $role_pemdes->givePermissionTo(['manage-users']); // Pemerintah bisa mengelola pengguna
        $role_ortu->givePermissionTo(['view-post']); // Orang tua hanya bisa melihat

        // Mengambil user berdasarkan ID dan assign role
        $user = User::find(1); // Admin
        $user2 = User::find(2); // Bidan
        $user3 = User::find(3); // Pemerintah
        $user4 = User::find(4); // Kader
        $user5 = User::find(5); // Ortu

        // Assign role hanya jika user ada
        if ($user) {
            $user->assignRole('admin');
        }

        if ($user2) {
            $user2->assignRole('bidan');
        }

        if ($user3) {
            $user3->assignRole('pemdes');
        }

        if ($user4) {
            $user4->assignRole('kader');
        }

        if ($user5) {
            $user5->assignRole('ortu');
        }
    }
}
