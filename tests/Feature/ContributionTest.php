<?php

namespace Tests\Feature;

use App\Models\ContentSubmission;
use App\Models\News;
use App\Models\SaktiContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContributionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_access_contribution_form(): void
    {
        $response = $this->get(route('contributions.create'));
        $response->assertStatus(200);
        $response->assertSee('Ruang Kontributor Sahabat Guru');
    }

    public function test_guest_can_submit_news_contribution(): void
    {
        $response = $this->post(route('contributions.store'), [
            'type' => 'news',
            'author_name' => 'Drs. H. Mulyadi, M.Pd.',
            'author_email' => 'mulyadi@sekolah.sch.id',
            'author_phone' => '081234567890',
            'school_origin' => 'SMAN 1 Ciamis',
            'title' => 'Peringatan Hari Guru Nasional dan Aksi Peduli Literasi',
            'summary' => 'Kegiatan literasi yang dihadiri ratusan guru di kabupaten ciamis.',
            'content' => 'Acara ini terselenggara dengan sangat meriah dan diikuti oleh seluruh keluarga besar guru dengan antusias tinggi.',
            'event_date' => '2026-10-25',
            'agreement' => '1',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('content_submissions', [
            'type' => 'news',
            'author_name' => 'Drs. H. Mulyadi, M.Pd.',
            'author_email' => 'mulyadi@sekolah.sch.id',
            'school_origin' => 'SMAN 1 Ciamis',
            'title' => 'Peringatan Hari Guru Nasional dan Aksi Peduli Literasi',
            'status' => 'pending',
        ]);
    }

    public function test_guest_can_submit_sakti_module_contribution(): void
    {
        $response = $this->post(route('contributions.store'), [
            'type' => 'sakti',
            'sakti_category' => 'koding_kka',
            'badge' => 'SMP',
            'author_name' => 'Dewi Lestari, S.Kom.',
            'author_email' => 'dewi@guru.id',
            'author_phone' => '089876543210',
            'school_origin' => 'SMPN 2 Ciamis',
            'title' => 'Modul Pengenalan Logika Pemrograman Scratch untuk Kelas VII',
            'summary' => 'Panduan pengajaran koding dasar berorientasi computational thinking.',
            'content' => 'Modul ini dirancang agar guru informatika dapat mengajarkan konsep algoritma sederhana dengan mudah dan menyenangkan bagi siswa SMP.',
            'file_url' => 'https://drive.google.com/file/d/test12345',
            'agreement' => '1',
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseHas('content_submissions', [
            'type' => 'sakti',
            'sakti_category' => 'koding_kka',
            'badge' => 'SMP',
            'author_name' => 'Dewi Lestari, S.Kom.',
            'file_url' => 'https://drive.google.com/file/d/test12345',
            'status' => 'pending',
        ]);
    }

    public function test_honeypot_traps_spam_submission(): void
    {
        $response = $this->post(route('contributions.store'), [
            'type' => 'news',
            'author_name' => 'Spam Bot',
            'author_email' => 'bot@spammer.com',
            'author_phone' => '08111111111',
            'school_origin' => 'Spam School',
            'title' => 'Promosi Judi Online',
            'content' => 'Klik link ini segera untuk mendapatkan bonus berlimpah http://spam.com',
            'agreement' => '1',
            'website_hp' => 'http://spam-trap.com', // Filled honeypot
        ]);

        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('content_submissions', [
            'author_email' => 'bot@spammer.com',
        ]);
    }

    public function test_admin_can_view_submissions_list_and_detail(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $submission = ContentSubmission::create([
            'type' => 'news',
            'author_name' => 'Guru Penulis',
            'author_email' => 'guru@sekolah.id',
            'author_phone' => '081234567890',
            'school_origin' => 'SDN 1 Pusat',
            'title' => 'Festival Inovasi Guru Penggerak',
            'summary' => 'Ringkasan festival.',
            'content' => 'Isi berita festival inovasi guru yang diadakan secara luar jaringan.',
            'status' => 'pending',
        ]);

        // Index
        $responseIndex = $this->actingAs($admin)->get(route('admin.submissions.index'));
        $responseIndex->assertStatus(200);
        $responseIndex->assertSee('Festival Inovasi Guru Penggerak');

        // Show
        $responseShow = $this->actingAs($admin)->get(route('admin.submissions.show', $submission->id));
        $responseShow->assertStatus(200);
        $responseShow->assertSee('Guru Penulis');
        $responseShow->assertSee('SDN 1 Pusat');
    }

    public function test_admin_can_approve_news_submission_and_publish_it(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $submission = ContentSubmission::create([
            'type' => 'news',
            'author_name' => 'Ahmad Santoso',
            'author_email' => 'ahmad@sch.id',
            'author_phone' => '081233445566',
            'school_origin' => 'SMKN 1 Kawali',
            'title' => 'Pameran Produk Kreatif Siswa SMK',
            'summary' => 'Pameran hasil karya siswa.',
            'content' => 'Pameran karya siswa vokasi SMK yang berhasil memikat para pelaku industri.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.submissions.approve', $submission->id), [
            'title' => 'Pameran Produk Kreatif Siswa SMKN 1 Kawali',
            'author_name' => 'Ahmad Santoso',
            'school_origin' => 'SMKN 1 Kawali',
            'summary' => 'Pameran hasil karya siswa SMKN 1 Kawali.',
            'content' => 'Pameran karya siswa vokasi SMK yang berhasil memikat para pelaku industri.',
        ]);

        $response->assertRedirect();

        $submission->refresh();
        $this->assertEquals('approved', $submission->status);
        $this->assertNotNull($submission->published_news_id);

        // Verify News created in news table
        $this->assertDatabaseHas('news', [
            'id' => $submission->published_news_id,
            'title' => 'Pameran Produk Kreatif Siswa SMKN 1 Kawali',
            'is_published' => true,
        ]);
    }

    public function test_admin_can_approve_sakti_submission_and_publish_it(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $submission = ContentSubmission::create([
            'type' => 'sakti',
            'sakti_category' => 'pembelajaran_mendalam',
            'badge' => 'SD',
            'author_name' => 'Rina Wijaya, S.Pd.',
            'author_email' => 'rina@sd.id',
            'author_phone' => '087788990011',
            'school_origin' => 'SDN 3 Ciamis',
            'title' => 'Modul Kolaboratif Pembelajaran IPA Tematik',
            'summary' => 'Ringkasan modul IPA.',
            'content' => 'Uraian langkah pembelajaran IPA tematik berbasis eksplorasi lingkungan sekitar sekolah.',
            'file_url' => 'https://drive.google.com/test-ipa',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.submissions.approve', $submission->id), [
            'title' => 'Modul Kolaboratif Pembelajaran IPA Tematik Terpadu',
            'author_name' => 'Rina Wijaya, S.Pd.',
            'school_origin' => 'SDN 3 Ciamis',
            'sakti_category' => 'pembelajaran_mendalam',
            'badge' => 'SD',
            'summary' => 'Ringkasan modul IPA.',
            'content' => 'Uraian langkah pembelajaran IPA tematik berbasis eksplorasi lingkungan sekitar sekolah.',
        ]);

        $response->assertRedirect();

        $submission->refresh();
        $this->assertEquals('approved', $submission->status);
        $this->assertNotNull($submission->published_sakti_id);

        // Verify SaktiContent created in sakti_contents table
        $this->assertDatabaseHas('sakti_contents', [
            'id' => $submission->published_sakti_id,
            'title' => 'Modul Kolaboratif Pembelajaran IPA Tematik Terpadu',
            'category' => 'pembelajaran_mendalam',
            'badge' => 'SD',
        ]);
    }

    public function test_admin_can_reject_submission_with_notes(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $submission = ContentSubmission::create([
            'type' => 'news',
            'author_name' => 'Kontributor Kurang Lengkap',
            'author_email' => 'test@test.com',
            'title' => 'Artikel Singkat Sekali',
            'content' => 'Hanya satu baris kalimat yang belum memenuhi kriteria berita.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.submissions.reject', $submission->id), [
            'admin_notes' => 'Naskah terlalu singkat dan belum memuat foto dokumentasi kegiatan.',
        ]);

        $response->assertRedirect();

        $submission->refresh();
        $this->assertEquals('rejected', $submission->status);
        $this->assertEquals('Naskah terlalu singkat dan belum memuat foto dokumentasi kegiatan.', $submission->admin_notes);
    }

    public function test_admin_can_delete_submission(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $submission = ContentSubmission::create([
            'type' => 'news',
            'author_name' => 'Kontributor Hapus',
            'author_email' => 'hapus@test.com',
            'title' => 'Naskah Akan Dihapus',
            'content' => 'Naskah yang salah kirim dan minta dibatalkan.',
            'status' => 'pending',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.submissions.destroy', $submission->id));
        $response->assertRedirect(route('admin.submissions.index'));

        $this->assertDatabaseMissing('content_submissions', [
            'id' => $submission->id,
        ]);
    }

    public function test_unauthenticated_user_cannot_access_admin_submissions(): void
    {
        $response = $this->get(route('admin.submissions.index'));
        $response->assertRedirect(route('admin.login'));
    }
}
