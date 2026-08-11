<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PublicDetailVisibilityTest extends TestCase
{
    use RefreshDatabase;

    protected int $umkmRoleId;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('roles')->insert(['name' => 'Admin Desa']);
        $this->umkmRoleId = DB::table('roles')->insertGetId(['name' => 'Pelaku UMKM']);
    }

    public function test_approved_umkm_detail_page_shows_umkm_and_products(): void
    {
        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan dan minuman']);
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Sari Rasa',
            'address' => 'Jl. Desa 1',
            'contact' => '081234567890',
            'description' => 'Kuliner khas desa',
            'status' => 'Disetujui',
        ]);

        Product::create([
            'umkm_id' => $umkm->id,
            'name' => 'Nasi Liwet',
            'description' => 'Menu andalan',
            'price' => 25000,
            'image_path' => null,
        ]);

        Product::create([
            'umkm_id' => $umkm->id,
            'name' => 'Es Cendol',
            'description' => 'Minuman segar',
            'price' => 12000,
            'image_path' => null,
        ]);

        $response = $this->get(route('public.umkm.show', $umkm->id));

        $response->assertOk();
        $response->assertSee('Sari Rasa');
        $response->assertSee('Kuliner khas desa');
        $response->assertSee('Nasi Liwet');
        $response->assertSee('Es Cendol');
        $response->assertSee('Rp 25.000');
        $response->assertSee('Rp 12.000');
        $response->assertSee('Hubungi Penjual');
    }

    public function test_public_detail_page_can_search_products_within_selected_umkm(): void
    {
        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan dan minuman']);
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Sari Rasa',
            'address' => 'Jl. Desa 1',
            'contact' => '081234567890',
            'description' => 'Kuliner khas desa',
            'status' => 'Disetujui',
        ]);

        Product::create([
            'umkm_id' => $umkm->id,
            'name' => 'Nasi Liwet',
            'description' => 'Menu andalan',
            'price' => 25000,
            'image_path' => null,
        ]);

        Product::create([
            'umkm_id' => $umkm->id,
            'name' => 'Es Cendol',
            'description' => 'Minuman segar',
            'price' => 12000,
            'image_path' => null,
        ]);

        $response = $this->get(route('public.umkm.show', ['id' => $umkm->id, 'search' => 'nasi']));

        $response->assertOk();
        $response->assertSee('Menampilkan hasil pencarian untuk');
        $response->assertSee('Nasi Liwet');
        $response->assertDontSee('Es Cendol');
    }

    public function test_pending_umkm_detail_page_is_not_publicly_accessible(): void
    {
        $category = Category::create(['name' => 'Kerajinan', 'description' => 'Produk kriya']);
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $umkm = Umkm::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'Anyaman Desa',
            'address' => 'Jl. Anyam 3',
            'contact' => '081299999999',
            'description' => 'Masih menunggu verifikasi',
            'status' => 'Menunggu Verifikasi',
        ]);

        $this->get(route('public.umkm.show', $umkm->id))->assertNotFound();
    }
}