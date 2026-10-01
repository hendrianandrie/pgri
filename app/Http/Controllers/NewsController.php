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

        if (!empty($search)) {
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
        $news = News::published()->where('slug', $slug)->firstOrFail();

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
}
