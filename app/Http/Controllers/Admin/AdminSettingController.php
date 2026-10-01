<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminSettingController extends Controller
{
    public function heroSettings()
    {
        $hero = [
            'badge' => Setting::get('hero_badge', 'Platform Transformasi Edukasi & Profesi Guru'),
            'title' => Setting::get('hero_title', 'Mewujudkan Guru <span class="text-danger">Profesional</span>, <span class="text-success" style="color: #15803d !important;">Sejahtera</span> & <span class="text-warning" style="color: #d97706 !important;">Melek AI</span>'),
            'description' => Setting::get('hero_description', 'Persatuan Guru Republik Indonesia (PGRI) mengabdi sejak 1945. Bersama ekosistem SAKTI PGRI, kami mendorong pembelajaran mendalam, repositori perangkat ajar, serta kemampuan Koding, KKA & AI bagi seluruh pendidik Indonesia.'),
            'btn1_text' => Setting::get('hero_btn1_text', 'Jelajahi SAKTI PGRI'),
            'btn1_url' => Setting::get('hero_btn1_url', '/sakti'),
            'btn2_text' => Setting::get('hero_btn2_text', 'Profil & Sejarah'),
            'btn2_url' => Setting::get('hero_btn2_url', '/profile'),
            'image' => Setting::get('hero_image', 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=800&q=80'),
            'card1_title' => Setting::get('hero_card1_title', '500+ Modul SAKTI'),
            'card1_subtitle' => Setting::get('hero_card1_subtitle', 'Deep Learning, Koding & AI'),
            'card2_title' => Setting::get('hero_card2_title', 'Pelatihan Koding & AI'),
            'card2_subtitle' => Setting::get('hero_card2_subtitle', 'Berpikir Komputasional Guru'),
            'stat_number' => Setting::get('hero_stat_number', '3.4M+'),
            'stat_label' => Setting::get('hero_stat_label', 'Guru & Tenaga Kependidikan Terhubung'),
        ];

        return view('admin.settings.hero', compact('hero'));
    }

    public function updateHeroSettings(Request $request)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string',
            'description' => 'required|string',
            'btn1_text' => 'nullable|string|max:100',
            'btn1_url' => 'nullable|string|max:255',
            'btn2_text' => 'nullable|string|max:100',
            'btn2_url' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string|max:1000',
            'card1_title' => 'nullable|string|max:100',
            'card1_subtitle' => 'nullable|string|max:255',
            'card2_title' => 'nullable|string|max:100',
            'card2_subtitle' => 'nullable|string|max:255',
            'stat_number' => 'nullable|string|max:50',
            'stat_label' => 'nullable|string|max:255',
        ]);

        Setting::set('hero_badge', $validated['badge'] ?? 'Platform Transformasi Edukasi & Profesi Guru');
        Setting::set('hero_title', $validated['title']);
        Setting::set('hero_description', $validated['description']);
        Setting::set('hero_btn1_text', $validated['btn1_text'] ?? 'Jelajahi SAKTI PGRI');
        Setting::set('hero_btn1_url', $validated['btn1_url'] ?? '/sakti');
        Setting::set('hero_btn2_text', $validated['btn2_text'] ?? 'Profil & Sejarah');
        Setting::set('hero_btn2_url', $validated['btn2_url'] ?? '/profile');
        Setting::set('hero_card1_title', $validated['card1_title'] ?? '500+ Modul SAKTI');
        Setting::set('hero_card1_subtitle', $validated['card1_subtitle'] ?? 'Deep Learning, Koding & AI');
        Setting::set('hero_card2_title', $validated['card2_title'] ?? 'Pelatihan Koding & AI');
        Setting::set('hero_card2_subtitle', $validated['card2_subtitle'] ?? 'Berpikir Komputasional Guru');
        Setting::set('hero_stat_number', $validated['stat_number'] ?? '3.4M+');
        Setting::set('hero_stat_label', $validated['stat_label'] ?? 'Guru & Tenaga Kependidikan Terhubung');

        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'hero_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('hero', $filename, 'public');
            Setting::set('hero_image', '/storage/' . $path);
        } elseif (!empty($validated['image_url'])) {
            Setting::set('hero_image', $validated['image_url']);
        }

        return redirect()->route('admin.hero-settings')->with('success', 'Pengaturan Hero Banner Beranda berhasil diperbarui!');
    }

    public function contactSettings()
    {
        $office = [
            'address' => Setting::get('office_address', 'Jl. Tanah Abang III No. 24, Gambir, Jakarta Pusat, DKI Jakarta 10160'),
            'phone' => Setting::get('office_phone', '(021) 3844932 / 3846665'),
            'email' => Setting::get('office_email', 'sekretariat@pgri.or.id'),
            'whatsapp' => Setting::get('office_whatsapp', '0812-3456-7890'),
            'hours' => Setting::get('office_hours', 'Senin - Jumat: 08:00 - 16:00 WIB'),
        ];

        return view('admin.settings.contact', compact('office'));
    }

    public function updateContactSettings(Request $request)
    {
        $validated = $request->validate([
            'address' => 'required|string|max:500',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'whatsapp' => 'required|string|max:100',
            'hours' => 'required|string|max:255',
        ]);

        Setting::set('office_address', $validated['address']);
        Setting::set('office_phone', $validated['phone']);
        Setting::set('office_email', $validated['email']);
        Setting::set('office_whatsapp', $validated['whatsapp']);
        Setting::set('office_hours', $validated['hours']);

        return redirect()->route('admin.contact-settings')->with('success', 'Informasi Kontak & Sekretariat berhasil diperbarui!');
    }
}
