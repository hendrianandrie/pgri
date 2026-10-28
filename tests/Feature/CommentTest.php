<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\News;
use App\Models\SaktiContent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    private function createNews(): News
    {
        return News::create([
            'title' => 'Kegiatan Seminar Nasional PGRI',
            'slug' => 'kegiatan-seminar-nasional-pgri',
            'author' => 'Tim Humas PGRI',
            'published_at' => now(),
            'excerpt' => 'Ringkasan seminar nasional.',
            'content' => 'Isi berita lengkap seminar nasional untuk para guru.',
            'is_published' => true,
        ]);
    }

    private function createSaktiContent(string $category = 'pembelajaran_mendalam'): SaktiContent
    {
        return SaktiContent::create([
            'category' => $category,
            'title' => 'Modul Pembelajaran Mendalam SD',
            'slug' => 'modul-pembelajaran-mendalam-sd',
            'author' => 'Instruktur SAKTI',
            'published_at' => now(),
            'summary' => 'Ringkasan materi pembelajaran mendalam.',
            'content' => 'Isi lengkap panduan pembelajaran mendalam di SD.',
            'badge' => 'SD',
        ]);
    }

    public function test_guest_can_submit_comment_and_it_defaults_to_pending(): void
    {
        $news = $this->createNews();

        $response = $this->post(route('news.comment.store', $news->slug), [
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@example.com',
            'comment' => 'Acara ini sangat bermanfaat untuk guru-guru.',
        ]);

        $response->assertSessionHas('comment_success');

        $this->assertDatabaseHas('comments', [
            'news_id' => $news->id,
            'name' => 'Ahmad Dahlan',
            'email' => 'ahmad@example.com',
            'comment' => 'Acara ini sangat bermanfaat untuk guru-guru.',
            'is_approved' => false,
        ]);
    }

    public function test_pending_comment_is_not_displayed_on_news_page(): void
    {
        $news = $this->createNews();

        Comment::create([
            'news_id' => $news->id,
            'name' => 'Komentator Pending',
            'email' => 'pending@example.com',
            'comment' => 'Komentar ini belum disetujui admin.',
            'is_approved' => false,
        ]);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertStatus(200);
        $response->assertDontSee('Komentator Pending');
        $response->assertDontSee('Komentar ini belum disetujui admin.');
    }

    public function test_approved_comment_is_displayed_on_news_page(): void
    {
        $news = $this->createNews();

        Comment::create([
            'news_id' => $news->id,
            'name' => 'Guru Hebat',
            'email' => 'guru@example.com',
            'comment' => 'Komentar yang sudah disetujui tampil disini.',
            'is_approved' => true,
        ]);

        $response = $this->get(route('news.show', $news->slug));

        $response->assertStatus(200);
        $response->assertSee('Guru Hebat');
        $response->assertSee('Komentar yang sudah disetujui tampil disini.');
    }

    public function test_honeypot_prevents_spam_submission(): void
    {
        $news = $this->createNews();

        $response = $this->post(route('news.comment.store', $news->slug), [
            'name' => 'Spam Bot',
            'email' => 'bot@spammer.com',
            'comment' => 'Klik link judi online ini http://spam.com',
            'website_hp' => 'http://spam-trap.com', // Honeypot filled by bot
        ]);

        $response->assertSessionHas('comment_success');

        // Should NOT be saved in database
        $this->assertDatabaseMissing('comments', [
            'email' => 'bot@spammer.com',
        ]);
    }

    public function test_admin_can_view_comments_and_toggle_approval(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $news = $this->createNews();

        $comment = Comment::create([
            'news_id' => $news->id,
            'name' => 'Pak Guru Budi',
            'email' => 'budi@example.com',
            'comment' => 'Semoga kegiatan serupa diadakan lagi.',
            'is_approved' => false,
        ]);

        // Access comments list
        $response = $this->actingAs($admin)->get(route('admin.comments.index'));
        $response->assertStatus(200);
        $response->assertSee('Pak Guru Budi');

        // Toggle approve
        $toggleResponse = $this->actingAs($admin)->post(route('admin.comments.toggleApprove', $comment->id));
        $toggleResponse->assertRedirect();

        $this->assertTrue($comment->fresh()->is_approved);

        // Toggle back to unapproved
        $toggleResponse2 = $this->actingAs($admin)->post(route('admin.comments.toggleApprove', $comment->id));
        $toggleResponse2->assertRedirect();

        $this->assertFalse($comment->fresh()->is_approved);
    }

    public function test_admin_can_delete_comment(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $news = $this->createNews();

        $comment = Comment::create([
            'news_id' => $news->id,
            'name' => 'Komentar Spam',
            'email' => 'spam@test.com',
            'comment' => 'Hapus saya segera.',
            'is_approved' => false,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.comments.destroy', $comment->id));
        $response->assertRedirect();

        $this->assertDatabaseMissing('comments', [
            'id' => $comment->id,
        ]);
    }

    public function test_guest_can_submit_comment_to_sakti_module(): void
    {
        $sakti = $this->createSaktiContent();

        $response = $this->post(route('sakti.comment.store', $sakti->slug), [
            'name' => 'Guru Penggerak',
            'email' => 'penggerak@example.com',
            'comment' => 'Materi koding ini sangat aplikatif untuk siswa.',
        ]);

        $response->assertSessionHas('comment_success');

        $this->assertDatabaseHas('comments', [
            'sakti_content_id' => $sakti->id,
            'name' => 'Guru Penggerak',
            'email' => 'penggerak@example.com',
            'comment' => 'Materi koding ini sangat aplikatif untuk siswa.',
            'is_approved' => false,
        ]);
    }

    public function test_approved_sakti_comment_is_displayed_on_module_page(): void
    {
        $sakti = $this->createSaktiContent();

        // Pending comment
        Comment::create([
            'sakti_content_id' => $sakti->id,
            'name' => 'Pending Guru',
            'email' => 'pending@example.com',
            'comment' => 'Komentar belum disetujui di modul sakti.',
            'is_approved' => false,
        ]);

        // Approved comment
        Comment::create([
            'sakti_content_id' => $sakti->id,
            'name' => 'Approved Guru',
            'email' => 'approved@example.com',
            'comment' => 'Komentar yang disetujui di modul sakti.',
            'is_approved' => true,
        ]);

        $response = $this->get(route('sakti.show', $sakti->slug));

        $response->assertStatus(200);
        $response->assertSee('Approved Guru');
        $response->assertSee('Komentar yang disetujui di modul sakti.');
        $response->assertDontSee('Pending Guru');
        $response->assertDontSee('Komentar belum disetujui di modul sakti.');
    }

    public function test_admin_can_filter_comments_by_source(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $news = $this->createNews();
        $sakti = $this->createSaktiContent();

        Comment::create([
            'news_id' => $news->id,
            'name' => 'Komentar Berita Unik',
            'email' => 'berita@test.com',
            'comment' => 'Isi komentar berita.',
            'is_approved' => true,
        ]);

        Comment::create([
            'sakti_content_id' => $sakti->id,
            'name' => 'Komentar Sakti Unik',
            'email' => 'sakti@test.com',
            'comment' => 'Isi komentar modul sakti.',
            'is_approved' => true,
        ]);

        // Filter news only
        $responseNews = $this->actingAs($admin)->get(route('admin.comments.index', ['source' => 'news']));
        $responseNews->assertSee('Komentar Berita Unik');
        $responseNews->assertDontSee('Komentar Sakti Unik');

        // Filter sakti only
        $responseSakti = $this->actingAs($admin)->get(route('admin.comments.index', ['source' => 'sakti']));
        $responseSakti->assertSee('Komentar Sakti Unik');
        $responseSakti->assertDontSee('Komentar Berita Unik');
    }

    public function test_unauthenticated_user_cannot_access_admin_comments(): void
    {
        $response = $this->get(route('admin.comments.index'));
        $response->assertRedirect(route('admin.login'));
    }
}
