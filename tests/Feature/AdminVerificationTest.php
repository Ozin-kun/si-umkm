<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AdminVerificationTest extends TestCase
{
    use RefreshDatabase;

    protected int $adminRoleId;
    protected int $umkmRoleId;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminRoleId = DB::table('roles')->insertGetId(['name' => 'Admin Desa']);
        $this->umkmRoleId = DB::table('roles')->insertGetId(['name' => 'Pelaku UMKM']);
    }

    public function test_admin_can_approve_umkm_and_write_verification_log(): void
    {
        $admin = User::factory()->create(['role_id' => $this->adminRoleId]);
        $umkmUser = User::factory()->create(['role_id' => $this->umkmRoleId]);
        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan dan minuman']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'category_id' => $category->id,
            'name' => 'UMKM Sukses',
            'address' => 'Jl. Mawar 1',
            'contact' => '08123456789',
            'status' => 'Menunggu Verifikasi',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.verify', $umkm->id), [
            'status' => 'Disetujui',
            'reason' => null,
        ]);

        $response->assertRedirect(route('admin.dashboard'));

        $this->assertDatabaseHas('umkms', [
            'id' => $umkm->id,
            'status' => 'Disetujui',
        ]);

        $this->assertDatabaseHas('verification_logs', [
            'umkm_id' => $umkm->id,
            'admin_id' => $admin->id,
            'status' => 'Disetujui',
        ]);
    }

    public function test_admin_must_provide_reason_when_rejecting_or_requesting_revision(): void
    {
        $admin = User::factory()->create(['role_id' => $this->adminRoleId]);
        $umkmUser = User::factory()->create(['role_id' => $this->umkmRoleId]);
        $category = Category::create(['name' => 'Kerajinan', 'description' => 'Produk kriya']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'category_id' => $category->id,
            'name' => 'UMKM Coba',
            'address' => 'Jl. Melati 2',
            'contact' => '08123456780',
            'status' => 'Menunggu Verifikasi',
        ]);

        $response = $this->actingAs($admin)
            ->from(route('admin.dashboard'))
            ->post(route('admin.verify', $umkm->id), [
                'status' => 'Ditolak',
                'reason' => '',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHasErrors('reason');

        $this->assertDatabaseMissing('verification_logs', [
            'umkm_id' => $umkm->id,
            'admin_id' => $admin->id,
        ]);

        $this->assertDatabaseHas('umkms', [
            'id' => $umkm->id,
            'status' => 'Menunggu Verifikasi',
        ]);
    }

    public function test_admin_cannot_reset_umkm_status_back_to_pending(): void
    {
        $admin = User::factory()->create(['role_id' => $this->adminRoleId]);
        $umkmUser = User::factory()->create(['role_id' => $this->umkmRoleId]);
        $category = Category::create(['name' => 'Jasa', 'description' => 'Layanan usaha']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'category_id' => $category->id,
            'name' => 'UMKM Pending',
            'address' => 'Jl. Kenanga 3',
            'contact' => '08123456781',
            'status' => 'Disetujui',
        ]);

        $response = $this->actingAs($admin)
            ->from(route('admin.dashboard'))
            ->post(route('admin.verify', $umkm->id), [
                'status' => 'Menunggu Verifikasi',
                'reason' => 'Reset manual',
            ]);

        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHasErrors('status');

        $this->assertDatabaseMissing('verification_logs', [
            'umkm_id' => $umkm->id,
            'status' => 'Menunggu Verifikasi',
        ]);

        $this->assertDatabaseHas('umkms', [
            'id' => $umkm->id,
            'status' => 'Disetujui',
        ]);
    }

    public function test_admin_dashboard_shows_recent_verification_history(): void
    {
        $admin = User::factory()->create(['role_id' => $this->adminRoleId]);
        $umkmUser = User::factory()->create(['role_id' => $this->umkmRoleId]);
        $category = Category::create(['name' => 'Kerajinan', 'description' => 'Produk kriya']);
        $umkm = Umkm::create([
            'user_id' => $umkmUser->id,
            'category_id' => $category->id,
            'name' => 'UMKM Audit',
            'address' => 'Jl. Audit 1',
            'contact' => '08123456782',
            'status' => 'Menunggu Verifikasi',
        ]);

        $this->actingAs($admin)->post(route('admin.verify', $umkm->id), [
            'status' => 'Revisi',
            'reason' => 'Foto belum jelas',
        ])->assertRedirect(route('admin.dashboard'));

        $response = $this->actingAs($admin)->get(route('admin.dashboard'));

        $response->assertOk();
        $response->assertSee('Riwayat Verifikasi Terbaru');
        $response->assertSee('Foto belum jelas');
        $response->assertSee('UMKM Audit');
    }
}