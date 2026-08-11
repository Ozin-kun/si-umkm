<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Umkm;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UmkmProfileCrudTest extends TestCase
{
    use RefreshDatabase;

    protected int $umkmRoleId;

    protected function setUp(): void
    {
        parent::setUp();

        DB::table('roles')->insert(['name' => 'Admin Desa']);
        $this->umkmRoleId = DB::table('roles')->insertGetId(['name' => 'Pelaku UMKM']);
    }

    public function test_umkm_can_create_profile_and_store_place_photos(): void
    {
        Storage::fake('public');

        $category = Category::create(['name' => 'Kuliner', 'description' => 'Makanan dan minuman']);
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        $response = $this->actingAs($user)->post(route('umkm.store'), [
            'name' => 'Warung Makan Suka Rasa',
            'category_id' => $category->id,
            'address' => 'Jl. Melati No. 12',
            'contact' => '081234567890',
            'description' => 'Makanan rumahan khas desa',
            'latitude' => -7.701,
            'longitude' => 110.516,
            'place_images' => [
                UploadedFile::fake()->image('depan.jpg'),
                UploadedFile::fake()->image('dalam.jpg'),
            ],
        ]);

        $response->assertRedirect(route('umkm.dashboard'));

        $this->assertDatabaseHas('umkms', [
            'user_id' => $user->id,
            'name' => 'Warung Makan Suka Rasa',
            'status' => 'Menunggu Verifikasi',
        ]);

        $umkm = Umkm::where('user_id', $user->id)->firstOrFail();

        $this->assertSame(2, $umkm->placePhotos()->count());
        Storage::disk('public')->assertExists($umkm->placePhotos()->first()->image_path);
        Storage::disk('public')->assertExists($umkm->placePhotos()->skip(1)->first()->image_path);

        $this->actingAs($user)
            ->get(route('umkm.dashboard'))
            ->assertOk()
            ->assertSee('Warung Makan Suka Rasa');
    }

    public function test_umkm_can_update_existing_profile_without_creating_duplicate(): void
    {
        $category = Category::create(['name' => 'Kerajinan', 'description' => 'Produk kriya']);
        $user = User::factory()->create(['role_id' => $this->umkmRoleId]);

        Umkm::create([
            'user_id' => $user->id,
            'category_id' => $category->id,
            'name' => 'UMKM Lama',
            'address' => 'Jl. Lama 1',
            'contact' => '0812000000',
            'description' => 'Data awal',
            'latitude' => -7.7,
            'longitude' => 110.5,
            'status' => 'Disetujui',
        ]);

        $response = $this->actingAs($user)->post(route('umkm.store'), [
            'name' => 'UMKM Baru',
            'category_id' => $category->id,
            'address' => 'Jl. Baru 2',
            'contact' => '0812999999',
            'description' => 'Data diperbarui',
            'latitude' => -7.702,
            'longitude' => 110.517,
        ]);

        $response->assertRedirect(route('umkm.dashboard'));

        $this->assertDatabaseCount('umkms', 1);
        $this->assertDatabaseHas('umkms', [
            'user_id' => $user->id,
            'name' => 'UMKM Baru',
            'address' => 'Jl. Baru 2',
            'contact' => '0812999999',
            'status' => 'Menunggu Verifikasi',
        ]);
    }
}