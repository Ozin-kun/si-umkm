<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Category;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Roles
        Role::create(['name' => 'Admin Desa']);
        Role::create(['name' => 'Pelaku UMKM']);

        // 2. Buat Akun Admin Pertama
        User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@desa.com',
            'password' => bcrypt('password123'),
            'role_id' => 1,
        ]);

        // 3. Buat Kategori Awal
        Category::create(['name' => 'Kuliner', 'description' => 'Makanan, katering, dan minuman olahan']);
        Category::create(['name' => 'Kerajinan', 'description' => 'Kerajinan bambu, batik, kriya khas daerah Prambanan']);
        Category::create(['name' => 'Jasa', 'description' => 'Jasa pertukangan, menjahit, reparasi, dll']);
    }
}
