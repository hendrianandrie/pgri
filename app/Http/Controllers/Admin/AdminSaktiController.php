<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SaktiContent;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSaktiController extends Controller
{
    public function index(Request $request)
    {
        return redirect()->route('admin.sakti.pembelajaran-mendalam');
    }

    public function pembelajaranMendalam(Request $request)
    {
        return $this->renderPillarView($request, 'pembelajaran_mendalam', 'Pembelajaran Mendalam', 'Deep Learning & Pedagogi Modern', 'brain', 'sky');
    }

    public function rumahPendidikan(Request $request)
    {
        return $this->renderPillarView($request, 'rumah_pendidikan', 'Rumah Pendidikan', 'Repositori Modul & Perangkat Ajar', 'folder-open', 'emerald');
    }

    public function pid(Request $request)
    {
        return $this->renderPillarView($request, 'pid', 'PID (Pusat Informasi & Data)', 'Warta Resmi, Berita & Edaran Digital', 'bullhorn', 'amber');
    }

    public function kodingKka(Request $request)
    {
        return $this->renderPillarView($request, 'koding_kka', 'Koding & AI (KKA)', 'Berpikir Komputasional & Kecerdasan Artifisial', 'code', 'purple');
    }

    private function renderPillarView(Request $request, string $category, string $title, string $subtitle, string $icon, string $color)
    {
        $query = SaktiContent::where('category', $category);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('school_origin', 'like', '%' . $search . '%')
                  ->orWhere('badge', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('tingkat')) {
            $query->where('badge', $request->tingkat);
        }

        $contents = $query->latest('published_at')->paginate(10)->withQueryString();

        $meta = [
            'category' => $category,
            'title' => $title,
            'subtitle' => $subtitle,
            'icon' => $icon,
            'color' => $color,
            'count' => SaktiContent::where('category', $category)->count(),
        ];

        return view('admin.sakti.index', compact('contents', 'meta'));
    }

    public function store(Request $request)
    {
        $rules = [
            'category' => 'required|in:pembelajaran_mendalam,rumah_pendidikan,pid,koding_kka',
            'title' => 'required|string|max:255',
            'tingkat' => 'required|string|in:PAUD,TK,SD,SMP,SMA/K,Umum',
            'author' => 'required|string|max:255',
            'school_origin' => 'nullable|string|max:255',
            'file_url' => 'required|string|max:1000',
            'image' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'badge' => 'nullable|string|max:50',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ];

        $validated = $request->validate($rules);

        // Map tingkat to badge
        $validated['badge'] = $validated['tingkat'];

        // Handle Image Upload
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'sakti_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sakti', $filename, 'public');
            $validated['image'] = '/storage/' . $path;
        }

        // Author and school origin text
        $authorText = !empty($validated['author']) ? $validated['author'] : 'Pengurus PGRI';
        $badgeText = !empty($validated['badge']) ? $validated['badge'] : 'Umum';
        $schoolText = !empty($validated['school_origin']) ? " ({$validated['school_origin']})" : "";

        $categoryName = match($validated['category']) {
            'pembelajaran_mendalam' => 'Pembelajaran Mendalam',
            'rumah_pendidikan' => 'Rumah Pendidikan',
            'pid' => 'Pusat Informasi & Data',
            'koding_kka' => 'Koding & KKA',
            default => 'SAKTI',
        };

        // Auto-fill summary and content if blank
        if (empty($validated['summary'])) {
            $validated['summary'] = "Modul {$validated['title']} untuk jenjang {$badgeText}, disusun oleh {$authorText}{$schoolText}.";
        }
        if (empty($validated['content'])) {
            $validated['content'] = "Modul materi {$categoryName} untuk jenjang {$badgeText} yang disusun oleh {$authorText}{$schoolText}. Silakan akses materi secara langsung melalui tautan modul.";
        }

        $validated['author'] = $authorText;
        $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        $validated['is_featured'] = $request->has('is_featured');
        $validated['published_at'] = now();

        SaktiContent::create($validated);

        $redirectRoute = match ($validated['category']) {
            'pembelajaran_mendalam' => 'admin.sakti.pembelajaran-mendalam',
            'rumah_pendidikan' => 'admin.sakti.rumah-pendidikan',
            'pid' => 'admin.sakti.pid',
            'koding_kka' => 'admin.sakti.koding-kka',
            default => 'admin.sakti.index',
        };

        return redirect()->route($redirectRoute)->with('success', 'Modul ' . $categoryName . ' berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $content = SaktiContent::findOrFail($id);

        $meta = match ($content->category) {
            'pembelajaran_mendalam' => [
                'category' => 'pembelajaran_mendalam',
                'title' => 'Pembelajaran Mendalam',
                'subtitle' => 'Deep Learning & Pedagogi Modern',
                'icon' => 'brain',
                'color' => 'sky',
                'back_route' => 'admin.sakti.pembelajaran-mendalam',
            ],
            'rumah_pendidikan' => [
                'category' => 'rumah_pendidikan',
                'title' => 'Rumah Pendidikan',
                'subtitle' => 'Repositori Modul & Perangkat Ajar',
                'icon' => 'folder-open',
                'color' => 'emerald',
                'back_route' => 'admin.sakti.rumah-pendidikan',
            ],
            'pid' => [
                'category' => 'pid',
                'title' => 'PID (Pusat Informasi & Data)',
                'subtitle' => 'Warta Resmi, Berita & Edaran Digital',
                'icon' => 'bullhorn',
                'color' => 'amber',
                'back_route' => 'admin.sakti.pid',
            ],
            'koding_kka' => [
                'category' => 'koding_kka',
                'title' => 'Koding & AI (KKA)',
                'subtitle' => 'Berpikir Komputasional & Kecerdasan Artifisial',
                'icon' => 'code',
                'color' => 'purple',
                'back_route' => 'admin.sakti.koding-kka',
            ],
            default => [
                'category' => $content->category,
                'title' => 'Modul SAKTI',
                'subtitle' => 'Konten SAKTI',
                'icon' => 'book-bookmark',
                'color' => 'red',
                'back_route' => 'admin.sakti.index',
            ],
        };

        return view('admin.sakti.edit', compact('content', 'meta'));
    }

    public function update(Request $request, $id)
    {
        $content = SaktiContent::findOrFail($id);
        $category = $content->category;

        $rules = [
            'title' => 'required|string|max:255',
            'tingkat' => 'required|string|in:PAUD,TK,SD,SMP,SMA/K,Umum',
            'author' => 'required|string|max:255',
            'school_origin' => 'nullable|string|max:255',
            'file_url' => 'required|string|max:1000',
            'image' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'badge' => 'nullable|string|max:50',
            'summary' => 'nullable|string',
            'content' => 'nullable|string',
            'is_featured' => 'nullable|boolean',
        ];

        $validated = $request->validate($rules);

        $validated['badge'] = $validated['tingkat'];

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'sakti_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('sakti', $filename, 'public');
            $validated['image'] = '/storage/' . $path;
        }

        $authorText = !empty($validated['author']) ? $validated['author'] : ($content->author ?: 'Pengurus PGRI');
        $validated['author'] = $authorText;
        $validated['school_origin'] = $validated['school_origin'] ?? $content->school_origin;
        $validated['is_featured'] = $request->has('is_featured');

        if (empty($validated['summary'])) {
            $schoolText = !empty($validated['school_origin']) ? " ({$validated['school_origin']})" : "";
            $validated['summary'] = $content->summary ?: "Modul {$validated['title']} untuk jenjang " . ($validated['badge'] ?? 'Umum') . ", disusun oleh {$validated['author']}{$schoolText}";
        }
        if (empty($validated['content'])) {
            $validated['content'] = $content->content ?: "Modul pembelajaran SAKTI PGRI.";
        }

        if ($validated['title'] !== $content->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . rand(100, 999);
        }

        $content->update($validated);

        $redirectRoute = match ($category) {
            'pembelajaran_mendalam' => 'admin.sakti.pembelajaran-mendalam',
            'rumah_pendidikan' => 'admin.sakti.rumah-pendidikan',
            'pid' => 'admin.sakti.pid',
            'koding_kka' => 'admin.sakti.koding-kka',
            default => 'admin.sakti.index',
        };

        return redirect()->route($redirectRoute)->with('success', 'Data modul berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $content = SaktiContent::findOrFail($id);
        $category = $content->category;
        $content->delete();

        $redirectRoute = match ($category) {
            'pembelajaran_mendalam' => 'admin.sakti.pembelajaran-mendalam',
            'rumah_pendidikan' => 'admin.sakti.rumah-pendidikan',
            'pid' => 'admin.sakti.pid',
            'koding_kka' => 'admin.sakti.koding-kka',
            default => 'admin.sakti.index',
        };

        return redirect()->route($redirectRoute)->with('success', 'Konten berhasil dihapus!');
    }
}
