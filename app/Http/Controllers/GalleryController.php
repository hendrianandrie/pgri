<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::query();

        $category = $request->input('category', 'all');

        if ($category !== 'all' && !empty($category)) {
            $query->where('category', 'like', '%' . $category . '%');
        }

        $galleries = $query->latest('event_date')->latest('id')->paginate(12)->withQueryString();

        $categories = [
            'all' => 'Semua Kegiatan',
            'Konferensi' => 'Konferensi & Raker',
            'Workshop' => 'Workshop & Diklat',
            'HUT PGRI' => 'HUT PGRI & HGN',
            'Kemanusiaan' => 'Kemanusiaan & Sosial',
        ];

        return view('gallery', compact('galleries', 'categories', 'category'));
    }
}
