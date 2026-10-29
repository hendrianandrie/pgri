<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentSubmission;
use App\Models\News;
use App\Models\SaktiContent;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminSubmissionController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $type = $request->query('type', 'all');
        $search = $request->query('q');

        $query = ContentSubmission::with(['publishedNews', 'publishedSakti'])->latest();

        if ($status === 'pending') {
            $query->pending();
        } elseif ($status === 'approved') {
            $query->approved();
        } elseif ($status === 'rejected') {
            $query->rejected();
        }

        if ($type === 'news') {
            $query->where('type', 'news');
        } elseif ($type === 'sakti') {
            $query->where('type', 'sakti');
        }

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author_name', 'like', "%{$search}%")
                    ->orWhere('author_email', 'like', "%{$search}%")
                    ->orWhere('school_origin', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        try {
            $submissions = $query->paginate(12)->withQueryString();

            $counts = [
                'all' => ContentSubmission::count(),
                'pending' => ContentSubmission::pending()->count(),
                'approved' => ContentSubmission::approved()->count(),
                'rejected' => ContentSubmission::rejected()->count(),
                'news' => ContentSubmission::where('type', 'news')->count(),
                'sakti' => ContentSubmission::where('type', 'sakti')->count(),
            ];
        } catch (\Throwable) {
            $submissions = new LengthAwarePaginator([], 0, 12);
            $counts = [
                'all' => 0,
                'pending' => 0,
                'approved' => 0,
                'rejected' => 0,
                'news' => 0,
                'sakti' => 0,
            ];
        }

        return view('admin.submissions.index', compact('submissions', 'status', 'type', 'search', 'counts'));
    }

    public function show($id)
    {
        $submission = ContentSubmission::with(['publishedNews', 'publishedSakti'])->findOrFail($id);

        return view('admin.submissions.show', compact('submission'));
    }

    public function approve(Request $request, $id)
    {
        $submission = ContentSubmission::findOrFail($id);

        $title = $request->filled('title') ? $request->input('title') : $submission->title;
        $author = $request->filled('author_name') ? $request->input('author_name') : $submission->author_name;
        $school = $request->filled('school_origin') ? $request->input('school_origin') : $submission->school_origin;
        $summary = $request->filled('summary') ? $request->input('summary') : $submission->summary;
        $content = $request->filled('content') ? $request->input('content') : $submission->content;

        if ($submission->type === 'news') {
            $authorFull = $school ? "{$author} ({$school})" : $author;
            $slug = News::generateUniqueSlug($title);
            $image = $submission->image ?: 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1000&q=80';

            $news = News::create([
                'title' => $title,
                'slug' => $slug,
                'author' => $authorFull,
                'published_at' => $submission->event_date ?: now(),
                'image' => $image,
                'excerpt' => $summary ?: Str::limit(strip_tags($content), 160),
                'content' => $content,
                'is_published' => true,
                'views_count' => 0,
            ]);

            $submission->published_news_id = $news->id;
            $targetUrl = route('news.show', $news->slug);
            $targetLabel = 'Berita PGRI';
        } else {
            $category = $request->input('sakti_category', $submission->sakti_category ?: 'pembelajaran_mendalam');
            $badge = $request->input('badge', $submission->badge ?: 'Umum');
            $fileUrl = $request->input('file_url', $submission->file_url);

            $sakti = SaktiContent::create([
                'category' => $category,
                'title' => $title,
                'slug' => Str::slug($title).'-'.rand(100, 999),
                'summary' => $summary,
                'content' => $content,
                'author' => $author,
                'school_origin' => $school,
                'image' => $submission->image,
                'file_url' => $fileUrl,
                'badge' => $badge,
                'views' => 0,
                'is_featured' => false,
                'published_at' => now(),
            ]);

            $submission->published_sakti_id = $sakti->id;
            $targetUrl = route('sakti.show', $sakti->slug);
            $targetLabel = 'Modul SAKTI';
        }

        $submission->status = 'approved';
        $submission->admin_notes = $request->input('admin_notes', 'Disetujui dan diterbitkan oleh Redaksi PGRI.');
        $submission->save();

        return redirect()->route('admin.submissions.show', $submission->id)
            ->with('success', "Kiriman berhasil disetujui dan kini telah tayang resmi di {$targetLabel}! [Lihat Hasil Tayang]({$targetUrl})");
    }

    public function reject(Request $request, $id)
    {
        $submission = ContentSubmission::findOrFail($id);

        $request->validate([
            'admin_notes' => 'required|string|max:1000',
        ], [
            'admin_notes.required' => 'Mohon sertakan alasan penolakan atau catatan revisi.',
        ]);

        $submission->status = 'rejected';
        $submission->admin_notes = $request->input('admin_notes');
        $submission->save();

        return redirect()->back()->with('success', 'Status kiriman berhasil diubah menjadi Ditolak.');
    }

    public function destroy($id)
    {
        $submission = ContentSubmission::findOrFail($id);

        // Delete uploaded file if stored locally
        if ($submission->image && str_starts_with($submission->image, '/storage/submissions/')) {
            $relativePath = str_replace('/storage/', '', $submission->image);
            Storage::disk('public')->delete($relativePath);
        }

        $submission->delete();

        return redirect()->route('admin.submissions.index')
            ->with('success', 'Kiriman kontributor berhasil dihapus.');
    }
}
