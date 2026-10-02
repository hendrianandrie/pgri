<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use App\Models\Setting;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $executives = Executive::active()->get();

        $history = [
            'founded' => '25 November 1945',
            'place' => 'Surakarta (Solo), Jawa Tengah',
            'conference' => 'Kongres Guru Indonesia Pertama',
            'summary' => 'Persatuan Guru Republik Indonesia (PGRI) lahir 100 hari setelah Proklamasi Kemerdekaan Indonesia. Berawal dari Persatuan Pengabdurat Guru Indonesia (PGII) yang didirikan tahun 1912, para guru Indonesia berikrar menyatukan diri dalam satu wadah perjuangan PGRI demi mempertahankan Kemerdekaan, mencerdaskan kehidupan bangsa, dan membela hak serta nasib guru.',
        ];

        $rawMisi = Setting::get('profile_misi');
        if (!empty($rawMisi)) {
            $decoded = json_decode($rawMisi, true);
            $misiList = is_array($decoded) ? $decoded : array_values(array_filter(array_map('trim', explode("\n", $rawMisi))));
        } else {
            $misiList = [
                'Mewujudkan iklim profesionalisme guru dan tenaga kependidikan yang kompeten dan adaptif.',
                'Memperjuangkan perlindungan hukum, kesejahteraan, dan kepastian karir guru Indonesia.',
                'Mengembangkan transformasi digital pembelajaran berbasis teknologi, koding, dan AI (SAKTI).',
                'Memperkuat solidaritas, kepedulian sosial, dan kemitraan strategis dengan pemerintah.',
            ];
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
            'misi' => $misiList,
            'executives_badge' => Setting::get('profile_executives_badge', 'JABATAN ORGANISASI'),
            'executives_title' => Setting::get('profile_executives_title', 'Struktur Pengurus PGRI Cabang Ciamis'),
            'executives_subtitle' => Setting::get('profile_executives_subtitle', 'Jajaran kepemimpinan yang mengabdi pada Pengurus PGRI Cabang Ciamis.'),
        ];

        $visiMisi = [
            'visi' => $profile['visi'],
            'misi' => $misiList,
        ];

        return view('profile', compact('executives', 'history', 'visiMisi', 'profile'));
    }
}
