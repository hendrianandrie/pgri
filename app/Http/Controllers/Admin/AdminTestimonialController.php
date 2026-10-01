<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy('order', 'asc')->orderBy('id', 'asc')->get();
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_origin' => 'required|string|max:255',
            'quote' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'photo_url' => 'nullable|string|max:1000',
            'order' => 'nullable|integer',
        ]);

        $order = isset($validated['order']) ? $validated['order'] : (Testimonial::max('order') + 1);

        $photo = 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=100&q=80';

        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'testi_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('testimonials', $filename, 'public');
            $photo = asset('storage/' . $path);
        } elseif (!empty($validated['photo_url'])) {
            $photo = $validated['photo_url'];
        }

        Testimonial::create([
            'name' => $validated['name'],
            'role_origin' => $validated['role_origin'],
            'quote' => $validated['quote'],
            'rating' => $validated['rating'],
            'photo' => $photo,
            'order' => $order,
            'is_active' => true,
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni guru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $testimonial = Testimonial::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role_origin' => 'required|string|max:255',
            'quote' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'photo_url' => 'nullable|string|max:1000',
            'order' => 'nullable|integer',
        ]);

        if (isset($validated['order'])) {
            $testimonial->order = $validated['order'];
        }

        $testimonial->name = $validated['name'];
        $testimonial->role_origin = $validated['role_origin'];
        $testimonial->quote = $validated['quote'];
        $testimonial->rating = $validated['rating'];

        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'testi_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('testimonials', $filename, 'public');
            $testimonial->photo = asset('storage/' . $path);
        } elseif (!empty($validated['photo_url'])) {
            $testimonial->photo = $validated['photo_url'];
        }

        $testimonial->save();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni guru berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimoni berhasil dihapus!');
    }
}
