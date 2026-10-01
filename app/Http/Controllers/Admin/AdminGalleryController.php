<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminGalleryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $category = $request->input('category');

        $query = Gallery::latest('event_date')->latest('id');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (!empty($category) && $category !== 'all') {
            $query->where('category', $category);
        }

        $galleries = $query->paginate(9)->withQueryString();

        $categories = [
            'Kegiatan PGRI' => 'Kegiatan PGRI',
            'Konferensi & Raker' => 'Konferensi & Raker',
            'Workshop & Diklat' => 'Workshop & Diklat',
            'HUT PGRI & HGN' => 'HUT PGRI & HGN',
            'Kemanusiaan & Sosial' => 'Kemanusiaan & Sosial',
            'Lainnya' => 'Lainnya'
        ];

        return view('admin.galleries.index', compact('galleries', 'categories', 'search', 'category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'cover_url' => 'nullable|string|max:1000',
            'photo_files' => 'nullable|array',
            'photo_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'photo_urls' => 'nullable|string',
        ]);

        // Process cover photo
        $cover = null;
        if ($request->hasFile('cover_file')) {
            $file = $request->file('cover_file');
            $filename = 'cover_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('galleries/covers', $filename, 'public');
            $cover = '/storage/' . $path;
        } elseif (!empty($validated['cover_url'])) {
            $cover = $validated['cover_url'];
        }

        // Process documentation photos
        $photos = [];
        if ($request->hasFile('photo_files')) {
            foreach ($request->file('photo_files') as $file) {
                if ($file->isValid()) {
                    $filename = 'doc_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('galleries/photos', $filename, 'public');
                    $photos[] = '/storage/' . $path;
                }
            }
        }

        // Process additional photo URLs (separated by newlines or commas)
        if (!empty($validated['photo_urls'])) {
            $urls = preg_split('/[\r\n,]+/', $validated['photo_urls']);
            foreach ($urls as $url) {
                $trimmed = trim($url);
                if (!empty($trimmed) && filter_var($trimmed, FILTER_VALIDATE_URL)) {
                    $photos[] = $trimmed;
                }
            }
        }

        // If no cover is uploaded but photos are uploaded, use first photo as cover
        if (empty($cover) && !empty($photos)) {
            $cover = $photos[0];
        }

        // If cover is present but no extra photos, put cover into photos array
        if (!empty($cover) && empty($photos)) {
            $photos[] = $cover;
        }

        // If neither is present, fallback placeholder
        if (empty($cover)) {
            $cover = 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800';
            $photos[] = $cover;
        }

        Gallery::create([
            'title' => $validated['title'],
            'category' => $validated['category'] ?? 'Kegiatan PGRI',
            'event_date' => $validated['event_date'] ?? now()->toDateString(),
            'location' => $validated['location'] ?? 'Indonesia',
            'description' => $validated['description'],
            'cover_image' => $cover,
            'image' => $cover,
            'photos' => array_values(array_unique($photos)),
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'Dokumentasi & Galeri kegiatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'cover_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'cover_url' => 'nullable|string|max:1000',
            'photo_files' => 'nullable|array',
            'photo_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'photo_urls' => 'nullable|string',
            'remove_photos' => 'nullable|array',
        ]);

        $gallery->title = $validated['title'];
        $gallery->category = $validated['category'] ?? $gallery->category;
        $gallery->event_date = $validated['event_date'] ?? $gallery->event_date;
        $gallery->location = $validated['location'] ?? $gallery->location;
        $gallery->description = $validated['description'];

        // Update cover if new one provided
        if ($request->hasFile('cover_file')) {
            $file = $request->file('cover_file');
            $filename = 'cover_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('galleries/covers', $filename, 'public');
            $gallery->cover_image = '/storage/' . $path;
            $gallery->image = $gallery->cover_image;
        } elseif (!empty($validated['cover_url'])) {
            $gallery->cover_image = $validated['cover_url'];
            $gallery->image = $gallery->cover_image;
        }

        // Get current photos
        $currentPhotos = $gallery->photos_list;

        // Remove photos marked for deletion
        if (!empty($validated['remove_photos']) && is_array($validated['remove_photos'])) {
            $currentPhotos = array_values(array_filter($currentPhotos, function($p) use ($validated) {
                return !in_array($p, $validated['remove_photos']);
            }));
        }

        // Append newly uploaded photos
        if ($request->hasFile('photo_files')) {
            foreach ($request->file('photo_files') as $file) {
                if ($file->isValid()) {
                    $filename = 'doc_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('galleries/photos', $filename, 'public');
                    $currentPhotos[] = '/storage/' . $path;
                }
            }
        }

        // Append newly provided photo URLs
        if (!empty($validated['photo_urls'])) {
            $urls = preg_split('/[\r\n,]+/', $validated['photo_urls']);
            foreach ($urls as $url) {
                $trimmed = trim($url);
                if (!empty($trimmed) && filter_var($trimmed, FILTER_VALIDATE_URL)) {
                    $currentPhotos[] = $trimmed;
                }
            }
        }

        if (empty($currentPhotos) && !empty($gallery->cover_image)) {
            $currentPhotos[] = $gallery->cover_image;
        }

        $gallery->photos = array_values(array_unique($currentPhotos));
        $gallery->save();

        return redirect()->route('admin.galleries.index')->with('success', 'Dokumentasi & Galeri berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        $gallery->delete();

        return redirect()->route('admin.galleries.index')->with('success', 'Dokumentasi Galeri berhasil dihapus!');
    }
}
