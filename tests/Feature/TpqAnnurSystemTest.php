<?php

namespace Tests\Feature;

use App\Models\OrangTua;
use App\Models\Presensi;
use App\Models\Santri;
use App\Models\SetoranHafalan;
use App\Models\Surah;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TpqAnnurSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected Surah $surahAnNaba;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $this->surahAnNaba = Surah::create([
            'nomor_surah' => 78,
            'nama_surah' => "An-Naba'",
            'jumlah_ayat' => 40,
            'juz' => 30,
        ]);
    }

    public function test_admin_can_view_santri_index_and_create_santri(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.santri.index'));
        $response->assertStatus(200);

        $createResponse = $this->actingAs($this->admin)->post(route('admin.santri.store'), [
            'nis' => '2026101',
            'nama_lengkap' => 'Ahmad Bilal',
            'jenis_kelamin' => 'L',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '2016-01-01',
            'jilid_kelas' => 'Jilid 3',
            'status_aktif' => '1',
        ]);

        $createResponse->assertRedirect(route('admin.santri.index'));
        $this->assertDatabaseHas('santri', [
            'nis' => '2026101',
            'nama_lengkap' => 'Ahmad Bilal',
        ]);
    }

    public function test_admin_can_create_orang_tua_with_user_account(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.orang_tua.store'), [
            'name' => 'Pak Usman',
            'email' => 'usman@gmail.com',
            'password' => 'password123',
            'no_hp' => '081234567899',
            'alamat' => 'Bogor Barat',
        ]);

        $response->assertRedirect(route('admin.orang_tua.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'usman@gmail.com',
            'role' => 'parent',
        ]);
        $this->assertDatabaseHas('orang_tua', [
            'no_hp' => '081234567899',
        ]);
    }

    public function test_admin_can_save_bulk_presensi(): void
    {
        $santri = Santri::create([
            'nis' => '2026102',
            'nama_lengkap' => 'Siti Aisyah',
            'jenis_kelamin' => 'P',
            'jilid_kelas' => 'Jilid 2',
            'status_aktif' => true,
        ]);

        $tanggal = '2026-10-28';

        $response = $this->actingAs($this->admin)->post(route('admin.presensi.store'), [
            'tanggal' => $tanggal,
            'presensi' => [
                $santri->id => [
                    'status' => 'Hadir',
                    'keterangan' => 'Tepat waktu',
                ],
            ],
        ]);

        $response->assertRedirect(route('admin.presensi.index', ['tanggal' => $tanggal]));
        $this->assertDatabaseHas('presensi', [
            'santri_id' => $santri->id,
            'status' => 'Hadir',
        ]);
        $this->assertTrue(Presensi::where('santri_id', $santri->id)->whereDate('tanggal', $tanggal)->exists());
    }

    public function test_admin_can_record_setoran_hafalan(): void
    {
        $santri = Santri::create([
            'nis' => '2026103',
            'nama_lengkap' => 'Umar Wirahadi',
            'jenis_kelamin' => 'L',
            'jilid_kelas' => 'Jilid 4',
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($this->admin)->post(route('admin.setoran.store'), [
            'santri_id' => $santri->id,
            'surah_id' => $this->surahAnNaba->id,
            'jenis' => 'ziyadah',
            'ayat_mulai' => 1,
            'ayat_selesai' => 10,
            'nilai' => 'Mumtaz',
            'catatan' => 'Sangat fasih',
            'tanggal_setoran' => '2026-10-28',
        ]);

        $response->assertRedirect(route('admin.setoran.index'));
        $this->assertDatabaseHas('setoran_hafalan', [
            'santri_id' => $santri->id,
            'surah_id' => $this->surahAnNaba->id,
            'ayat_mulai' => 1,
            'ayat_selesai' => 10,
            'nilai' => 'Mumtaz',
        ]);
    }

    public function test_setoran_hafalan_validates_ayat_selesai_does_not_exceed_surah_length(): void
    {
        $santri = Santri::create([
            'nis' => '2026104',
            'nama_lengkap' => 'Zaidan',
            'jenis_kelamin' => 'L',
            'jilid_kelas' => 'Jilid 1',
            'status_aktif' => true,
        ]);

        // Surah An-Naba only has 40 verses
        $response = $this->actingAs($this->admin)->post(route('admin.setoran.store'), [
            'santri_id' => $santri->id,
            'surah_id' => $this->surahAnNaba->id,
            'jenis' => 'ziyadah',
            'ayat_mulai' => 1,
            'ayat_selesai' => 50,
            'nilai' => 'Mumtaz',
            'tanggal_setoran' => '2026-10-28',
        ]);

        $response->assertSessionHasErrors('ayat_selesai');
    }

    public function test_admin_can_generate_pdf_rapor(): void
    {
        $santri = Santri::create([
            'nis' => '2026105',
            'nama_lengkap' => 'Ali Zainal',
            'jenis_kelamin' => 'L',
            'jilid_kelas' => 'Jilid 3',
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.laporan.rapor', [
            'santri' => $santri->id,
            'bulan' => 10,
            'tahun' => 2026,
        ]));

        $response->assertStatus(200);
        $this->assertEquals('application/pdf', $response->headers->get('content-type'));
    }

    public function test_parent_can_view_dashboard_and_generate_own_child_rapor(): void
    {
        $parentUser = User::factory()->create(['role' => 'parent']);
        $orangTua = OrangTua::create(['user_id' => $parentUser->id]);

        $child = Santri::create([
            'orang_tua_id' => $orangTua->id,
            'nis' => '2026106',
            'nama_lengkap' => 'Anak Kandung',
            'jenis_kelamin' => 'L',
            'jilid_kelas' => 'Jilid 2',
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($parentUser)->get(route('parent.dashboard'));
        $response->assertStatus(200);
        $response->assertSee('Anak Kandung');

        $raporResponse = $this->actingAs($parentUser)->get(route('parent.rapor', [
            'santri' => $child->id,
            'bulan' => 10,
            'tahun' => 2026,
        ]));

        $raporResponse->assertStatus(200);
        $this->assertEquals('application/pdf', $raporResponse->headers->get('content-type'));
    }

    public function test_parent_cannot_generate_other_parents_child_rapor(): void
    {
        $parentUser1 = User::factory()->create(['role' => 'parent']);
        $orangTua1 = OrangTua::create(['user_id' => $parentUser1->id]);

        $parentUser2 = User::factory()->create(['role' => 'parent']);
        $orangTua2 = OrangTua::create(['user_id' => $parentUser2->id]);

        $otherChild = Santri::create([
            'orang_tua_id' => $orangTua2->id,
            'nis' => '2026107',
            'nama_lengkap' => 'Anak Orang Lain',
            'jenis_kelamin' => 'P',
            'jilid_kelas' => 'Jilid 1',
            'status_aktif' => true,
        ]);

        $response = $this->actingAs($parentUser1)->get(route('parent.rapor', [
            'santri' => $otherChild->id,
            'bulan' => 10,
            'tahun' => 2026,
        ]));

        $response->assertStatus(403);
    }
}

