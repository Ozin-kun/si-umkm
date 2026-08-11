<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UmkmDashboardStatusReasonTest extends TestCase
{
    use RefreshDatabase;

    protected int $umkmRoleId;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('roles')->insert(['name' => 'Admin Desa']);
        $this->umkmRoleId = DB::table('roles')->insertGetId(['name' => 'Pelaku UMKM']);
    }

    public function test_rejected_umkm_dashboard_shows_verification_reason(): void
    {
        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan dan minuman']);
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Warung Sederhana',
            'address' => 'Jl. Contoh 1',
            'contact' => '08123456789',
            'status' => 'Ditolak',
        ]);

        $umkm->verificationLogs()->create([
            'admin_id' => User::factory()->create(['role_id' => $this->umkmRoleId])->id,
            'status' => 'Ditolak',
            'reason' => 'Foto lokasi belum jelas',
        ]);

        $response = $this->actingAs($user)->get(route('umkm.dashboard'));

        $response->assertOk();
        $response->assertSee('Status Profil');
        $response->assertSee('DITOLAK');
        $response->assertSee('Alasan verifikasi');
        $response->assertSee('Foto lokasi belum jelas');
        $response->assertSee('Perbaiki data sesuai catatan di atas');
    }
}