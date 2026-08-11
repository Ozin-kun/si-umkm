<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UmkmProfileStatusTest extends TestCase
{
    use RefreshDatabase;

    protected int $umkmRoleId;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('roles')->insert(['name' => 'Admin Desa']);
        $this->umkmRoleId = DB::table('roles')->insertGetId(['name' => 'Pelaku UMKM']);
    }

    public function test_approved_umkm_profile_returns_to_pending_when_updated(): void
    {
        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan']);
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'UMKM Awal',
            'address' => 'Jl. Lama 1',
            'contact' => '0812000000',
            'status' => 'Disetujui',
        ]);

        $response = $this->actingAs($user)->post(route('umkm.store'), [
            'name' => 'UMKM Diperbarui',
            'category_id' => $category->id,
            'address' => 'Jl. Baru 2',
            'contact' => '0812999999',
            'description' => 'Deskripsi diperbarui',
            'latitude' => -7.7,
            'longitude' => 110.5,
        ]);

        $response->assertRedirect(route('umkm.dashboard'));

        $this->assertDatabaseHas('umkms', [
            'id' => $umkm->id,
            'name' => 'UMKM Diperbarui',
            'status' => 'Menunggu Verifikasi',
        ]);
    }
}