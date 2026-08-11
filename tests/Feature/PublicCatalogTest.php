<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PublicCatalogTest extends TestCase
{
    use RefreshDatabase;

    protected int $umkmRoleId;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('roles')->insert(['name' => 'Admin Desa']);
        $this->umkmRoleId = DB::table('roles')->insertGetId(['name' => 'Pelaku UMKM']);
    }

    public function test_only_approved_umkm_are_shown_on_public_catalog(): void
    {
        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan']);
        $owner = User::factory()->create(['role_id' => $this->umkmRoleId]);

        Umkm::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'name' => 'UMKM Disetujui',
            'address' => 'Jl. Maju 1',
            'contact' => '0812000000',
            'status' => 'Disetujui',
        ]);

        Umkm::create([
            'user_id' => User::factory()->create(['role_id' => $this->umkmRoleId])->id,
            'category_id' => $category->id,
            'name' => 'UMKM Menunggu',
            'address' => 'Jl. Maju 2',
            'contact' => '0812000001',
            'status' => 'Menunggu Verifikasi',
        ]);

        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('UMKM Disetujui');
        $response->assertDontSee('UMKM Menunggu');
    }

    public function test_public_search_filters_by_name(): void
    {
        $category = Category::create(['name' => 'Kerajinan', 'description' => 'Produk kriya']);
        $owner = User::factory()->create(['role_id' => $this->umkmRoleId]);

        Umkm::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'name' => 'Batik Joho',
            'address' => 'Jl. Batik 1',
            'contact' => '0812000002',
            'status' => 'Disetujui',
        ]);

        $response = $this->get(route('home', ['cari' => 'Batik']));

        $response->assertOk();
        $response->assertSee('Batik Joho');
    }

    public function test_public_filter_limits_results_by_category(): void
    {
        $kuliner = Category::create(['name' => 'Kuliner', 'description' => 'Makanan']);
        $kerajinan = Category::create(['name' => 'Kerajinan', 'description' => 'Produk kriya']);
        $owner = User::factory()->create(['role_id' => $this->umkmRoleId]);

        Umkm::create([
            'user_id' => $owner->id,
            'category_id' => $kuliner->id,
            'name' => 'Rasa Desa',
            'address' => 'Jl. Kuliner 1',
            'contact' => '0812000003',
            'status' => 'Disetujui',
        ]);

        Umkm::create([
            'user_id' => User::factory()->create(['role_id' => $this->umkmRoleId])->id,
            'category_id' => $kerajinan->id,
            'name' => 'Anyaman Indah',
            'address' => 'Jl. Kerajinan 2',
            'contact' => '0812000004',
            'status' => 'Disetujui',
        ]);

        $response = $this->get(route('home', ['kategori' => $kuliner->id]));

        $response->assertOk();
        $response->assertSee('Rasa Desa');
        $response->assertDontSee('Anyaman Indah');
    }

    public function test_public_catalog_lazy_loads_items_after_twelve(): void
    {
        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan']);

        for ($index = 1; $index <= 13; $index++) {
            $owner = User::factory()->create(['role_id' => $this->umkmRoleId]);

            Umkm::create([
                'user_id' => $owner->id,
                'category_id' => $category->id,
                'name' => 'UMKM ' . $index,
                'address' => 'Jl. Contoh ' . $index,
                'contact' => '0812000' . str_pad((string) $index, 3, '0', STR_PAD_LEFT),
                'status' => 'Disetujui',
            ]);
        }

        $firstPage = $this->get(route('home'));

        $firstPage->assertOk();
        $firstPage->assertSee('UMKM 1');
        $firstPage->assertSee('UMKM 12');
        $firstPage->assertDontSee('UMKM 13');
        $firstPage->assertSee('data-umkm-lazy-loader', false);

        $lazyResponse = $this->get(route('home', ['lazy' => 1, 'page' => 2]));

        $lazyResponse->assertOk();
        $lazyResponse->assertJsonStructure(['html', 'next_page_url']);
        $lazyResponse->assertJsonFragment(['next_page_url' => null]);
        $this->assertStringContainsString('UMKM 13', $lazyResponse->json('html'));
        $this->assertStringNotContainsString('UMKM 12', $lazyResponse->json('html'));
    }
}