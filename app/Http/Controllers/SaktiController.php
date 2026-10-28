<?php

namespace App\Http\Controllers;

use App\Models\SaktiContent;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SaktiController extends Controller
{
    public function index()
    {
        $deepLearning = SaktiContent::category('pembelajaran_mendalam')->latest('published_at')->take(4)->get();
        $rumahPendidikan = SaktiContent::category('rumah_pendidikan')->latest('published_at')->take(4)->get();
        $pid = SaktiContent::category('pid')->latest('published_at')->take(4)->get();
        $kodingKka = SaktiContent::category('koding_kka')->latest('published_at')->take(4)->get();

        return view('sakti.index', compact('deepLearning', 'rumahPendidikan', 'pid', 'kodingKka'));
    }

    public function pembelajaranMendalam(Request $request)
    {
        return $this->getPillarContent($request, 'pembelajaran_mendalam', 'sakti.pembelajaran_mendalam');
    }

    public function rumahPendidikan(Request $request)
    {
        return $this->getPillarContent($request, 'rumah_pendidikan', 'sakti.rumah_pendidikan');
    }

    public function pid(Request $request)
    {
        return $this->getPillarContent($request, 'pid', 'sakti.pid');
    }

    public function kodingKka(Request $request)
    {
        return $this->getPillarContent($request, 'koding_kka', 'sakti.koding_kka');
    }

    private function getPillarContent(Request $request, string $category, string $viewName)
    {
        $query = SaktiContent::category($category);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%'.$search.'%')
                    ->orWhere('author', 'like', '%'.$search.'%')
                    ->orWhere('school_origin', 'like', '%'.$search.'%')
                    ->orWhere('summary', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('tingkat')) {
            $query->where('badge', $request->tingkat);
        }

        $contents = $query->latest('published_at')->paginate(9)->withQueryString();

        return view($viewName, compact('contents'));
    }

    public function show($slug)
    {
        try {
            $content = SaktiContent::with('approvedComments')->where('slug', $slug)->firstOrFail();
        } catch (QueryException) {
            $content = SaktiContent::where('slug', $slug)->firstOrFail();
            $content->setRelation('approvedComments', collect());
        }

        $content->increment('views');

        $related = SaktiContent::category($content->category)
            ->where('id', '!=', $content->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('sakti.show', compact('content', 'related'));
    }

    public function storeComment(Request $request, $slug)
    {
        $content = SaktiContent::where('slug', $slug)->firstOrFail();

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

        try {
            $content->comments()->create([
                'name' => strip_tags($validated['name']),
                'email' => strip_tags($validated['email']),
                'comment' => strip_tags($validated['comment']),
                'is_approved' => false,
                'ip_address' => $request->ip(),
            ]);
        } catch (QueryException) {
            return redirect()->to(url()->previous().'#komentar')
                ->with('comment_success', 'Terima kasih! Komentar Anda berhasil dikirim.');
        }

        return redirect()->to(url()->previous().'#komentar')
            ->with('comment_success', 'Terima kasih! Komentar Anda berhasil dikirim dan akan tampil setelah ditinjau serta disetujui oleh admin.');
    }
}
