<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = News::orderBy('published_at', 'desc')->orderBy('id', 'desc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%");
            });
        }

        $newsList = $query->paginate(10)->withQueryString();

        return view('admin.news.index', compact('newsList', 'search'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string|max:1000',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'is_published' => 'nullable',
        ]);

        $image = 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1000&q=80';

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'news_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('news', $filename, 'public');
            $image = '/storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $image = $validated['image_url'];
        }

        $slug = News::generateUniqueSlug($validated['title']);
        $excerpt = !empty($validated['excerpt']) ? $validated['excerpt'] : Str::limit(strip_tags($validated['content']), 160);

        News::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'author' => $validated['author'],
            'published_at' => $validated['published_at'],
            'image' => $image,
            'excerpt' => $excerpt,
            'content' => $validated['content'],
            'is_published' => $request->has('is_published'),
            'views_count' => 0,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'Berita reportase kegiatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $news = News::findOrFail($id);
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, $id)
    {
        $news = News::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'published_at' => 'required|date',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string|max:1000',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'is_published' => 'nullable',
        ]);

        if ($validated['title'] !== $news->title) {
            $news->slug = News::generateUniqueSlug($validated['title'], $news->id);
        }

        $news->title = $validated['title'];
        $news->author = $validated['author'];
        $news->published_at = $validated['published_at'];
        $news->content = $validated['content'];
        $news->excerpt = !empty($validated['excerpt']) ? $validated['excerpt'] : Str::limit(strip_tags($validated['content']), 160);
        $news->is_published = $request->has('is_published');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'news_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('news', $filename, 'public');
            $news->image = '/storage/' . $path;
        } elseif (!empty($validated['image_url'])) {
            $news->image = $validated['image_url'];
        }

        $news->save();

        return redirect()->route('admin.news.index')->with('success', 'Berita reportase berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus!');
    }
}
