<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductAccessTest extends TestCase
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

    public function test_umkm_cannot_access_other_umkm_product_routes(): void
    {
        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan']);

        $owner = User::factory()->create(['role_id' => $this->umkmRoleId]);
        $intruder = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $ownerUmkm = Umkm::create([
            'user_id' => $owner->id,
            'category_id' => $category->id,
            'name' => 'UMKM Pemilik',
            'address' => 'Jl. Utama 1',
            'contact' => '0811111111',
            'status' => 'Disetujui',
        ]);

        Umkm::create([
            'user_id' => $intruder->id,
            'category_id' => $category->id,
            'name' => 'UMKM Lain',
            'address' => 'Jl. Utama 2',
            'contact' => '0822222222',
            'status' => 'Disetujui',
        ]);

        $product = Product::create([
            'umkm_id' => $ownerUmkm->id,
            'name' => 'Keripik',
            'description' => 'Renyah',
            'price' => 15000,
            'image_path' => null,
        ]);

        $this->actingAs($intruder)->get(route('umkm.product.edit', $product->id))->assertForbidden();
        $this->actingAs($intruder)->put(route('umkm.product.update', $product->id), [
            'name' => 'Keripik Baru',
            'price' => 20000,
            'description' => 'Tetap renyah',
        ])->assertForbidden();
        $this->actingAs($intruder)->delete(route('umkm.product.destroy', $product->id))->assertForbidden();
    }

    public function test_product_upload_rejects_non_image_and_oversized_files(): void
    {
        $category = Category::create(['name' => 'Jasa', 'description' => 'Layanan']);
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        Umkm::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'UMKM Upload',
            'address' => 'Jl. Melati 10',
            'contact' => '0813333333',
            'status' => 'Menunggu Verifikasi',
        ]);

        $this->actingAs($user)
            ->post(route('umkm.product.store'), [
                'name' => 'Produk PDF',
                'price' => 10000,
                'description' => 'Dokumen salah',
                'image' => UploadedFile::fake()->create('brochure.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('image');

        $this->actingAs($user)
            ->post(route('umkm.product.store'), [
                'name' => 'Produk Besar',
                'price' => 10000,
                'description' => 'File terlalu besar',
                'image' => UploadedFile::fake()->image('large.jpg')->size(3000),
            ])
            ->assertSessionHasErrors('image');
    }

    public function test_umkm_without_profile_is_redirected_from_product_routes(): void
    {
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $this->actingAs($user)
            ->get(route('umkm.product.index'))
            ->assertRedirect(route('umkm.dashboard'));

        $this->actingAs($user)
            ->get(route('umkm.product.create'))
            ->assertRedirect(route('umkm.dashboard'));

        $this->actingAs($user)
            ->post(route('umkm.product.store'), [
                'name' => 'Produk Baru',
                'price' => 10000,
                'description' => 'Tanpa profil usaha',
            ])
            ->assertRedirect(route('umkm.dashboard'));
    }
}