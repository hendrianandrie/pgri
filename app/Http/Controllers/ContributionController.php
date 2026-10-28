<?php

namespace App\Http\Controllers;

use App\Models\ContentSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ContributionController extends Controller
{
    public function create()
    {
        return view('contributions.create');
    }

    public function store(Request $request)
    {
        // Honeypot spam trap
        if ($request->filled('website_hp')) {
            return redirect()->route('contributions.create')
                ->with('success', 'Terima kasih! Konten Anda telah berhasil dikirim dan sedang dalam antrean kurasi tim Redaksi PGRI.');
        }

        $validated = $request->validate([
            'type' => 'required|in:news,sakti',
            'author_name' => 'required|string|max:150',
            'author_email' => 'required|email|max:150',
            'author_phone' => 'required|string|max:30',
            'school_origin' => 'required|string|max:200',
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:1000',
            'content' => 'required|string|min:50',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'image_url' => 'nullable|string|max:1000',
            'file_url' => 'nullable|url|max:1000',
            'event_date' => 'nullable|date',
            'sakti_category' => 'required_if:type,sakti|nullable|in:pembelajaran_mendalam,rumah_pendidikan,pid,koding_kka',
            'badge' => 'required_if:type,sakti|nullable|string|max:50',
            'agreement' => 'accepted',
        ], [
            'author_name.required' => 'Nama lengkap kontributor/penulis wajib diisi.',
            'author_email.required' => 'Alamat email aktif wajib diisi.',
            'author_phone.required' => 'Nomor WhatsApp wajib diisi untuk koordinasi redaksi.',
            'school_origin.required' => 'Asal sekolah / cabang PGRI wajib diisi.',
            'title.required' => 'Judul berita atau modul wajib diisi.',
            'content.required' => 'Isi naskah lengkap wajib diisi.',
            'content.min' => 'Isi naskah minimal 50 karakter agar layak dimuat.',
            'sakti_category.required_if' => 'Pilihan pilar SAKTI wajib dipilih untuk kiriman modul.',
            'badge.required_if' => 'Jenjang pendidikan wajib dipilih untuk kiriman modul.',
            'agreement.accepted' => 'Anda wajib menyetujui pernyataan keaslian materi dan etika publikasi.',
        ]);

        $image = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'submission_'.time().'_'.Str::random(8).'.'.$file->getClientOriginalExtension();
            $path = $file->storeAs('submissions', $filename, 'public');
            $image = '/storage/'.$path;
        } elseif (! empty($validated['image_url'])) {
            $image = $validated['image_url'];
        }

        $summary = $validated['summary'] ?? null;
        if (empty($summary)) {
            $summary = Str::limit(strip_tags($validated['content']), 180);
        }

        ContentSubmission::create([
            'type' => $validated['type'],
            'sakti_category' => $validated['sakti_category'] ?? null,
            'badge' => $validated['badge'] ?? null,
            'title' => strip_tags($validated['title']),
            'summary' => $summary,
            'content' => $validated['content'],
            'author_name' => strip_tags($validated['author_name']),
            'author_email' => strip_tags($validated['author_email']),
            'author_phone' => strip_tags($validated['author_phone']),
            'school_origin' => strip_tags($validated['school_origin']),
            'image' => $image,
            'file_url' => $validated['file_url'] ?? null,
            'event_date' => $validated['event_date'] ?? null,
            'status' => 'pending',
            'ip_address' => $request->ip(),
        ]);

        return redirect()->route('contributions.create')
            ->with('success', 'Terima kasih Bapak/Ibu Guru! Naskah Anda berhasil dikirim ke Redaksi PGRI. Tim redaksi kami akan memverifikasi dan menerbitkan kiriman Anda setelah proses kurasi.');
    }
}
