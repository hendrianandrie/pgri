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
        $rawSlides = Setting::get('hero_slides');
        if (!empty($rawSlides)) {
            $slides = json_decode($rawSlides, true) ?: [];
        } else {
            $currentImg = Setting::get('hero_image', '/storage/hero/hero_1790667887_WBKNbozY.jpeg');
            $slides = [
                $currentImg,
                'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1600&q=80',
                'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1600&q=80',
            ];
        }

        $hero = [
            'badge' => Setting::get('hero_badge', 'Platform Transformasi Edukasi & Profesi Guru'),
            'title' => Setting::get('hero_title', 'Mewujudkan Guru <span class="text-danger">Profesional</span>, <span class="text-success" style="color: #15803d !important;">Sejahtera</span> & <span class="text-warning" style="color: #d97706 !important;">Melek AI</span>'),
            'description' => Setting::get('hero_description', 'Persatuan Guru Republik Indonesia (PGRI) mengabdi sejak 1945. Bersama ekosistem SAKTI PGRI, kami mendorong pembelajaran mendalam, repositori perangkat ajar, serta kemampuan Koding, KKA & AI bagi seluruh pendidik Indonesia.'),
            'btn1_text' => Setting::get('hero_btn1_text', 'Jelajahi SAKTI PGRI'),
            'btn1_url' => Setting::get('hero_btn1_url', '/sakti'),
            'btn2_text' => Setting::get('hero_btn2_text', 'Profil & Sejarah'),
            'btn2_url' => Setting::get('hero_btn2_url', '/profile'),
            'image' => Setting::get('hero_image', $slides[0] ?? ''),
            'slides' => $slides,
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
            'card1_title' => 'nullable|string|max:100',
            'card1_subtitle' => 'nullable|string|max:255',
            'card2_title' => 'nullable|string|max:100',
            'card2_subtitle' => 'nullable|string|max:255',
            'stat_number' => 'nullable|string|max:50',
            'stat_label' => 'nullable|string|max:255',
            'existing_slides' => 'nullable|array',
            'existing_slides.*' => 'nullable|string',
            'new_slide_files.*' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:6144',
            'new_slide_url' => 'nullable|string|max:1000',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'image_url' => 'nullable|string|max:1000',
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

        // Manage slides array
        $slides = $request->input('existing_slides', []);
        if (!is_array($slides)) {
            $slides = [];
        }

        // Handle multiple new uploaded files
        if ($request->hasFile('new_slide_files')) {
            foreach ($request->file('new_slide_files') as $file) {
                if ($file->isValid()) {
                    $filename = 'hero_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs('hero', $filename, 'public');
                    $slides[] = '/storage/' . $path;
                }
            }
        }

        // Handle single legacy file if any
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $filename = 'hero_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('hero', $filename, 'public');
            $slides[] = '/storage/' . $path;
        }

        // Handle new slide URL(s)
        if (!empty($request->input('new_slide_url'))) {
            $newUrls = preg_split('/\r\n|\r|\n/', $request->input('new_slide_url'));
            foreach ($newUrls as $url) {
                $trimmedUrl = trim($url);
                if (!empty($trimmedUrl)) {
                    $slides[] = $trimmedUrl;
                }
            }
        }

        if (!empty($validated['image_url'])) {
            $slides[] = trim($validated['image_url']);
        }

        // Fallback default if empty
        if (empty($slides)) {
            $slides = [
                '/storage/hero/hero_1790667887_WBKNbozY.jpeg',
                'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1600&q=80',
            ];
        }

        $cleanSlides = array_values(array_unique(array_filter($slides)));
        Setting::set('hero_slides', json_encode($cleanSlides, JSON_UNESCAPED_SLASHES));
        Setting::set('hero_image', $cleanSlides[0] ?? '');

        return redirect()->route('admin.hero-settings')->with('success', 'Pengaturan Hero Banner Slider berhasil diperbarui!');
    }

    public function contactSettings()
    {
        $office = [
            'address' => Setting::get('office_address', 'Jl. Tanah Abang III No. 24, Gambir, Jakarta Pusat, DKI Jakarta 10160'),
            'phone' => Setting::get('office_phone', '(021) 3844932 / 3846665'),
            'email' => Setting::get('office_email', 'sekretariat@pgri.or.id'),
            'whatsapp' => Setting::get('office_whatsapp', '0812-3456-7890'),
            'hours' => Setting::get('office_hours', 'Senin - Jumat: 08:00 - 16:00 WIB'),
            'instagram' => Setting::get('office_instagram', '@pbpgri_official'),
            'tiktok' => Setting::get('office_tiktok', '@pbpgri_official'),
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
            'instagram' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',
        ]);

        Setting::set('office_address', $validated['address']);
        Setting::set('office_phone', $validated['phone']);
        Setting::set('office_email', $validated['email']);
        Setting::set('office_whatsapp', $validated['whatsapp']);
        Setting::set('office_hours', $validated['hours']);
        Setting::set('office_instagram', $validated['instagram'] ?? '@pbpgri_official');
        Setting::set('office_tiktok', $validated['tiktok'] ?? '@pbpgri_official');

        return redirect()->route('admin.contact-settings')->with('success', 'Informasi Kontak & Sekretariat berhasil diperbarui!');
    }

    public function profileSettings()
    {
        $rawMisi = Setting::get('profile_misi');
        if (!empty($rawMisi)) {
            $decoded = json_decode($rawMisi, true);
            $misiText = is_array($decoded) ? implode("\n", $decoded) : $rawMisi;
        } else {
            $misiText = "Mewujudkan iklim profesionalisme guru dan tenaga kependidikan yang kompeten dan adaptif.\nMemperjuangkan perlindungan hukum, kesejahteraan, dan kepastian karir guru Indonesia.\nMengembangkan transformasi digital pembelajaran berbasis teknologi, koding, dan AI (SAKTI).\nMemperkuat solidaritas, kepedulian sosial, dan kemitraan strategis dengan pemerintah.";
        }

        $profile = [
            'badge' => Setting::get('profile_badge', 'TENTANG ORGANISASI'),
            'title' => Setting::get('profile_title', 'Profil Persatuan Guru Republik Indonesia'),
            'subtitle' => Setting::get('profile_subtitle', 'Mengenal Visi, Misi, dan Jajaran Pengurus PGRI Cabang Ciamis.'),
            'visi_title' => Setting::get('profile_visi_title', 'Visi PGRI'),
            'visi_subtitle' => Setting::get('profile_visi_subtitle', 'Arah & Cita-cita Organisasi'),
            'visi' => Setting::get('profile_visi', 'Mewujudkan PGRI sebagai Organisasi Profesi yang Terpercaya, Dinamika, Bermartabat, dan Dicintai Anggotanya dalam Memajukan Pendidikan Nasional.'),
            'misi_title' => Setting::get('profile_misi_title', 'Misi PGRI'),
            'misi_subtitle' => Setting::get('profile_misi_subtitle', 'Empat Pilar Pelaksanaan Kerja'),
            'misi' => $misiText,
            'executives_badge' => Setting::get('profile_executives_badge', 'JABATAN ORGANISASI'),
            'executives_title' => Setting::get('profile_executives_title', 'Struktur Pengurus PGRI Cabang Ciamis'),
            'executives_subtitle' => Setting::get('profile_executives_subtitle', 'Jajaran kepemimpinan yang mengabdi pada Pengurus PGRI Cabang Ciamis.'),
        ];

        return view('admin.settings.profile', compact('profile'));
    }

    public function updateProfileSettings(Request $request)
    {
        $validated = $request->validate([
            'badge' => 'nullable|string|max:100',
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:500',
            'visi_title' => 'nullable|string|max:150',
            'visi_subtitle' => 'nullable|string|max:255',
            'visi' => 'required|string|max:2000',
            'misi_title' => 'nullable|string|max:150',
            'misi_subtitle' => 'nullable|string|max:255',
            'misi' => 'required|string',
            'executives_badge' => 'nullable|string|max:100',
            'executives_title' => 'nullable|string|max:255',
            'executives_subtitle' => 'nullable|string|max:500',
        ]);

        Setting::set('profile_badge', $validated['badge'] ?? 'TENTANG ORGANISASI');
        Setting::set('profile_title', $validated['title']);
        Setting::set('profile_subtitle', $validated['subtitle']);
        Setting::set('profile_visi_title', $validated['visi_title'] ?? 'Visi PGRI');
        Setting::set('profile_visi_subtitle', $validated['visi_subtitle'] ?? 'Arah & Cita-cita Organisasi');
        Setting::set('profile_visi', $validated['visi']);
        Setting::set('profile_misi_title', $validated['misi_title'] ?? 'Misi PGRI');
        Setting::set('profile_misi_subtitle', $validated['misi_subtitle'] ?? 'Empat Pilar Pelaksanaan Kerja');

        // Split misi lines and save as JSON array
        $lines = preg_split('/\r\n|\r|\n/', $validated['misi']);
        $cleanLines = [];
        foreach ($lines as $line) {
            $trimmed = trim($line);
            if ($trimmed !== '') {
                // remove leading numbers/bullets if user typed them like "1. " or "- "
                $trimmed = preg_replace('/^[0-9]+[\.\)]\s*|^[-*•]\s*/', '', $trimmed);
                if ($trimmed !== '') {
                    $cleanLines[] = $trimmed;
                }
            }
        }
        Setting::set('profile_misi', json_encode(array_values($cleanLines), JSON_UNESCAPED_UNICODE));

        Setting::set('profile_executives_badge', $validated['executives_badge'] ?? 'JABATAN ORGANISASI');
        Setting::set('profile_executives_title', $validated['executives_title'] ?? 'Struktur Pengurus PGRI Cabang Ciamis');
        Setting::set('profile_executives_subtitle', $validated['executives_subtitle'] ?? 'Jajaran kepemimpinan yang mengabdi pada Pengurus PGRI Cabang Ciamis.');

        return redirect()->route('admin.profile-settings')->with('success', 'Profil, Visi, dan Misi PGRI berhasil diperbarui!');
    }
}
