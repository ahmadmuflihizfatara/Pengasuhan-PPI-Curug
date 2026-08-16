<?php

namespace Tests\Feature;

use App\Models\AksesFitur;
use App\Models\KeluhanBarak;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class KeluhanBarakTest extends TestCase
{
    use RefreshDatabase;

    private function taruna(array $extra = []): User
    {
        return User::factory()->create(array_merge([
            'role'  => User::ROLE_TARUNA,
            'prodi' => 'PNB',
            'email' => 'taruna-keluhan-' . uniqid() . '@test.com',
        ], $extra));
    }

    private function pengasuh(): User
    {
        return User::factory()->create(['role' => User::ROLE_PENGASUH]);
    }

    private function admin(): User
    {
        return User::factory()->create(['role' => User::ROLE_ADMIN]);
    }

    private function buatKeluhan(User $user, array $extra = []): KeluhanBarak
    {
        return KeluhanBarak::create(array_merge([
            'user_id'           => $user->id,
            'email'             => $user->email,
            'nama'              => $user->name,
            'tanggal_pengajuan' => now(),
            'prodi'             => 'PNB',
            'asrama'            => 'Curug 1',
            'lorong'            => 'Lorong A',
            'nomor_barak'       => '12',
            'keterangan'        => 'Lampu kamar mati.',
            'status'            => 'Diajukan',
        ], $extra));
    }

    public function test_taruna_can_view_index(): void
    {
        $this->actingAs($this->taruna())
            ->get(route('keluhan-barak.index'))
            ->assertOk();
    }

    public function test_taruna_can_view_create_form(): void
    {
        $this->actingAs($this->taruna())
            ->get(route('keluhan-barak.create'))
            ->assertOk();
    }

    public function test_taruna_can_store_keluhan(): void
    {
        Storage::fake('public');
        $user = $this->taruna();

        $response = $this->actingAs($user)->post(route('keluhan-barak.store'), [
            'tanggal_pengajuan' => now()->toDateString(),
            'prodi'             => 'PNB',
            'asrama'            => 'Curug 1',
            'lorong'            => 'Lorong A',
            'nomor_barak'       => '12',
            'keterangan'        => 'Lampu kamar mati.',
            'lampiran'          => [UploadedFile::fake()->createWithContent('foto.pdf', "%PDF-1.4\n1 0 obj\n<<>>\nendobj\ntrailer\n<<>>\n%%EOF\n")],
        ]);

        $response->assertRedirect(route('keluhan-barak.index'));

        $this->assertDatabaseHas('keluhan_barak', [
            'user_id'            => $user->id,
            'email'              => $user->email,
            'nama'               => $user->name,
            'prodi'              => 'PNB',
            'asrama'             => 'Curug 1',
            'lorong'             => 'Lorong A',
            'nomor_barak'        => '12',
            'keterangan'         => 'Lampu kamar mati.',
            'status'             => 'Diajukan',
            'taruna_baca'        => true,
        ]);
    }

    public function test_store_rejects_lorong_yang_tidak_sesuai_asrama(): void
    {
        $user = $this->taruna();

        $this->actingAs($user)->post(route('keluhan-barak.store'), [
            'tanggal_pengajuan' => now()->toDateString(),
            'prodi'             => 'PNB',
            'asrama'            => 'Curug 1',
            'lorong'            => 'Lantai 2',
            'nomor_barak'       => '12',
            'keterangan'        => 'Test.',
        ])->assertSessionHasErrors('lorong');
    }

    public function test_taruna_tidak_bisa_akses_halaman_kelola(): void
    {
        $this->actingAs($this->taruna())
            ->get(route('keluhan-barak.kelola'))
            ->assertForbidden();
    }

    public function test_taruna_tidak_bisa_lihat_keluhan_milik_taruna_lain(): void
    {
        $keluhan = $this->buatKeluhan($this->taruna());

        $this->actingAs($this->taruna())
            ->get(route('keluhan-barak.show', $keluhan->id))
            ->assertForbidden();
    }

    public function test_pengasuh_dapat_mengelola_dan_mengubah_status(): void
    {
        $keluhan = $this->buatKeluhan($this->taruna());

        $this->actingAs($this->pengasuh())
            ->get(route('keluhan-barak.kelola'))
            ->assertOk();

        $this->actingAs($this->pengasuh())
            ->get(route('keluhan-barak.detail', $keluhan->id))
            ->assertOk();

        $this->actingAs($this->pengasuh())
            ->patch(route('keluhan-barak.updateStatus', $keluhan->id), [
                'status'             => 'Diproses',
                'catatan_pengasuhan' => 'Sedang ditindaklanjuti.',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('keluhan_barak', [
            'id'                 => $keluhan->id,
            'status'             => 'Diproses',
            'catatan_pengasuhan' => 'Sedang ditindaklanjuti.',
            'taruna_baca'        => false,
        ]);
    }

    public function test_status_ditolak_menandai_taruna_baca_false(): void
    {
        $keluhan = $this->buatKeluhan($this->taruna());

        $this->actingAs($this->pengasuh())
            ->patch(route('keluhan-barak.updateStatus', $keluhan->id), [
                'status' => 'Ditolak',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('keluhan_barak', [
            'id'          => $keluhan->id,
            'status'      => 'Ditolak',
            'taruna_baca' => false,
        ]);
    }

    public function test_taruna_dapat_melihat_index_dengan_data_dan_detail_keluhan_sendiri(): void
    {
        $user     = $this->taruna();
        $keluhan  = $this->buatKeluhan($user);

        $this->actingAs($user)
            ->get(route('keluhan-barak.index'))
            ->assertOk()
            ->assertSee('Curug 1');

        $this->actingAs($user)
            ->get(route('keluhan-barak.show', $keluhan->id))
            ->assertOk()
            ->assertSee($keluhan->keterangan);
    }

    public function test_pengasuh_dapat_melihat_detail_kelola_dengan_lampiran(): void
    {
        $keluhan = $this->buatKeluhan($this->taruna(), ['lampiran' => ['keluhan/foto.pdf']]);

        $this->actingAs($this->pengasuh())
            ->get(route('keluhan-barak.detail', $keluhan->id))
            ->assertOk()
            ->assertSee('foto.pdf');
    }

    public function test_pengasuh_diblokir_saat_akses_ditutup_namun_admin_tetap_boleh(): void
    {
        $keluhan = $this->buatKeluhan($this->taruna());
        AksesFitur::create(['fitur' => AksesFitur::KELUHAN_BARAK, 'diizinkan' => false]);

        $this->actingAs($this->pengasuh())
            ->patch(route('keluhan-barak.updateStatus', $keluhan->id), ['status' => 'Diproses'])
            ->assertRedirect(route('keluhan-barak.kelola'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('keluhan_barak', [
            'id'     => $keluhan->id,
            'status' => 'Diajukan',
        ]);

        $this->actingAs($this->admin())
            ->patch(route('keluhan-barak.updateStatus', $keluhan->id), ['status' => 'Diproses'])
            ->assertSessionHasNoErrors()
            ->assertRedirect();

        $this->assertDatabaseHas('keluhan_barak', [
            'id'     => $keluhan->id,
            'status' => 'Diproses',
        ]);
    }
}
