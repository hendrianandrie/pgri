<?php

namespace App\Http\Controllers;

use App\Models\Executive;
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

        $visiMisi = [
            'visi' => 'Mewujudkan PGRI sebagai Organisasi Profesi yang Terpercaya, Dinamika, Bermartabat, dan Dicintai Anggotanya dalam Memajukan Pendidikan Nasional.',
            'misi' => [
                'Mewujudkan iklim profesionalisme guru dan tenaga kependidikan yang kompeten dan adaptif.',
                'Memperjuangkan perlindungan hukum, kesejahteraan, dan kepastian karir guru Indonesia.',
                'Mengembangkan transformasi digital pembelajaran berbasis teknologi, koding, dan AI (SAKTI).',
                'Memperkuat solidaritas, kepedulian sosial, dan kemitraan strategis dengan pemerintah.',
            ]
        ];

        return view('profile', compact('executives', 'history', 'visiMisi'));
    }
}
