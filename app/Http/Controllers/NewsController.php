<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('q');

        $query = News::latestPublished();

        if (! empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        // Get featured/top news (first item if not searching)
        $featuredNews = null;
        if (empty($search)) {
            $featuredNews = (clone $query)->first();
            if ($featuredNews) {
                $query->where('id', '!=', $featuredNews->id);
            }
        }

        $newsList = $query->paginate(9)->withQueryString();

        return view('news.index', compact('newsList', 'featuredNews', 'search'));
    }

    public function show($slug)
    {
        $news = News::published()
            ->with('approvedComments')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $news->increment('views_count');

        // Recent other news
        $recentNews = News::published()
            ->where('id', '!=', $news->id)
            ->latestPublished()
            ->take(4)
            ->get();

        return view('news.show', compact('news', 'recentNews'));
    }

    public function storeComment(Request $request, $slug)
    {
        $news = News::published()->where('slug', $slug)->firstOrFail();

        // Honeypot anti-spam check
        if ($request->filled('website_hp')) {
            return redirect()->to(url()->previous().'#komentar')
                ->with('comment_success', 'Terima kasih! Komentar Anda berhasil dikirim dan akan tampil setelah disetujui oleh admin.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:150',
            'comment' => 'required|string|min:3|max:1000',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'comment.required' => 'Isi komentar tidak boleh kosong.',
            'comment.min' => 'Komentar minimal 3 karakter.',
            'comment.max' => 'Komentar maksimal 1000 karakter.',
        ]);

        $news->comments()->create([
            'name' => strip_tags($validated['name']),
            'email' => strip_tags($validated['email']),
            'comment' => strip_tags($validated['comment']),
            'is_approved' => false,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->to(url()->previous().'#komentar')
            ->with('comment_success', 'Terima kasih! Komentar Anda berhasil dikirim dan akan tampil setelah ditinjau serta disetujui oleh admin.');
    }
}
