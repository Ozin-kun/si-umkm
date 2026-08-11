<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RoleAccessTest extends TestCase
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

    public function test_admin_can_access_admin_dashboard_but_not_umkm_dashboard(): void
    {
        $admin = User::factory()->create(['role_id' => $this->adminRoleId]);

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
        $this->actingAs($admin)->get(route('umkm.dashboard'))->assertForbidden();
    }

    public function test_umkm_can_access_umkm_dashboard_but_not_admin_dashboard(): void
    {
        $umkm = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $this->actingAs($umkm)->get(route('umkm.dashboard'))->assertOk();
        $this->actingAs($umkm)->get(route('admin.dashboard'))->assertForbidden();
    }
}