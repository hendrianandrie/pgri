<?php

namespace Database\Seeders;

use App\Models\Executive;
use App\Models\Gallery;
use App\Models\SaktiContent;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Default Admin User
        User::factory()->create([
            'name' => 'Admin PGRI Pusat',
            'email' => 'admin@pgri.or.id',
        ]);

        // Executives (Pengurus PGRI)
        $executives = [
            [
                'name' => 'Prof. Dr. Unifah Rosyidi, M.Pd.',
                'position' => 'Ketua Umum PB PGRI',
                'unit' => 'Pengurus Besar PGRI Pusat',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&q=80&w=400',
                'bio' => 'Pemimpin penggerak advokasi hak guru dan transformasi digital pendidikan Indonesia.',
                'order' => 1,
            ],
            [
                'name' => 'Drs. H. Dudung Abdul Qodir, M.Pd.',
                'position' => 'Sekretaris Jenderal PB PGRI',
                'unit' => 'Pengurus Besar PGRI Pusat',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=400',
                'bio' => 'Mengordinasikan tata kelola organisasi, keanggotaan, dan komunikasi publik PGRI.',
                'order' => 2,
            ],
            [
                'name' => 'H. Basyarudin Thayib, M.Pd.',
                'position' => 'Bendahara Umum PB PGRI',
                'unit' => 'Pengurus Besar PGRI Pusat',
                'photo' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&q=80&w=400',
                'bio' => 'Mengelola keuangan organisasi dan kemandirian ekonomi guru anggota PGRI.',
                'order' => 3,
            ],
            [
                'name' => 'Dr. Dian Mahsunah, M.Pd.',
                'position' => 'Ketua Bidang Pengembangan Profesi & Kurikulum',
                'unit' => 'Departemen Pengembangan Akademik PGRI',
                'photo' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&q=80&w=400',
                'bio' => 'Fasilitator utama program Pembelajaran Mendalam & Rumah Pendidikan SAKTI.',
                'order' => 4,
            ],
            [
                'name' => 'Ir. Hendra Wijaya, M.T.',
                'position' => 'Ketua Bidang Transformasi Digital & Koding/KKA',
                'unit' => 'Pusat Literasi Digital & AI PGRI',
                'photo' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=400',
                'bio' => 'Pengembang kurikulum koding, kecerdasan buatan, dan komputasional untuk guru.',
                'order' => 5,
            ],
        ];

        foreach ($executives as $executive) {
            Executive::create($executive);
        }

        // Sakti Contents
        $saktiItems = [
            // Pembelajaran Mendalam
            [
                'category' => 'pembelajaran_mendalam',
                'title' => 'Panduan Penerapan Deep Learning & Mindful Pedagogi dalam Kurikulum',
                'slug' => Str::slug('Panduan Penerapan Deep Learning & Mindful Pedagogi dalam Kurikulum'),
                'summary' => 'Pendekatan Pembelajaran Mendalam (Deep Learning) menekankan pada pemahaman konseptual, berpikir kritis, serta keterhubungan materi dengan kehidupan nyata peserta didik.',
                'content' => 'Pembelajaran Mendalam (Deep Learning) bukan sekadar menghafal fakta, melainkan mengajak siswa mengeksplorasi makna, menganalisis struktur ide, dan memecahkan masalah kompleks. Melalui pendekatan Mindful, Meaningful, dan Joyful Learning, guru didorong untuk membangun ruang kelas yang interaktif dan reflektif.',
                'author' => 'Tim Pengembang Kurikulum PGRI',
                'image' => 'https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&q=80&w=800',
                'file_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'badge' => 'Pedagogi',
                'views' => 1420,
                'is_featured' => true,
                'published_at' => now()->subDays(2),
            ],
            [
                'category' => 'pembelajaran_mendalam',
                'title' => 'Strategi Formatif Asesmen & Umpan Balik Bermakna dalam Kelas',
                'slug' => Str::slug('Strategi Formatif Asesmen & Umpan Balik Bermakna dalam Kelas'),
                'summary' => 'Bagaimana memberikan asesmen proses yang memotivasi dan membantu siswa mengenali potensi serta area pengembangan diri secara kontinu.',
                'content' => 'Asesmen formatif berfungsi sebagai navigasi belajar. Dalam modul ini, guru disajikan instrumen asesmen diri, penilaian sejawat, dan rubrik umpan balik naratif yang konstruktif.',
                'author' => 'Dr. Dian Mahsunah, M.Pd.',
                'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&q=80&w=800',
                'badge' => 'Asesmen',
                'views' => 980,
                'is_featured' => false,
                'published_at' => now()->subDays(5),
            ],

            // Rumah Pendidikan
            [
                'category' => 'rumah_pendidikan',
                'title' => 'Repository Modul Ajar & Alur Tujuan Pembelajaran (ATP) Lengkap',
                'slug' => Str::slug('Repository Modul Ajar & Alur Tujuan Pembelajaran ATP Lengkap'),
                'summary' => 'Akses gratis ratusan Modul Ajar terstandar, LKPD interaktif, dan Perangkat Pembelajaran buatan karya Guru PGRI se-Indonesia.',
                'content' => 'Rumah Pendidikan SAKTI PGRI menyediakan repositori terbuka berbasis pengayaan mandiri. Guru dapat mengunduh, mengadaptasi, dan merevisi modul sesuai dengan karakteristik sekolah serta kesiapan siswa.',
                'author' => 'Pusat Sumber Belajar PGRI',
                'image' => 'https://images.unsplash.com/photo-1497633762265-9d179a990aa6?auto=format&fit=crop&q=80&w=800',
                'file_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'badge' => 'Perangkat Ajar',
                'views' => 2890,
                'is_featured' => true,
                'published_at' => now()->subDays(1),
            ],
            [
                'category' => 'rumah_pendidikan',
                'title' => 'Kumpulan Media Pembelajaran Visual & Video Interaktif',
                'slug' => Str::slug('Kumpulan Media Pembelajaran Visual & Video Interaktif'),
                'summary' => 'Koleksi infografis, animasi pendidikan, dan lembar kerja berbasis sains dan literasi digital.',
                'content' => 'Media visual membantu memperjelas konsep abstrak. Kumpulan media ini siap digunakan di layar proyektor maupun dibagikan ke gawai murid.',
                'author' => 'Tim Multimedia PGRI',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&q=80&w=800',
                'badge' => 'Media Ajar',
                'views' => 1750,
                'is_featured' => false,
                'published_at' => now()->subDays(4),
            ],

            // PID (Pusat Informasi Digital)
            [
                'category' => 'pid',
                'title' => 'Siaran Resmi PGRI: Dorong Peningkatan Kesejahteraan & Kepastian Status Guru',
                'slug' => Str::slug('Siaran Resmi PGRI Dorong Peningkatan Kesejahteraan Guru'),
                'summary' => 'Pengurus Besar PGRI terus memperjuangkan peningkatan tunjangan, pemenuhan kuota PPPK, serta perlindungan hukum bagi pendidik.',
                'content' => 'Dalam audensi terbaru dengan kementerian terkait, PB PGRI menegaskan komitmennya untuk mengawal regulasi kualifikasi, sertifikasi, serta jaminan perlindungan guru saat menjalankan tugas pengabdian di pelosok negeri.',
                'author' => 'Humas PB PGRI',
                'image' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&q=80&w=800',
                'badge' => 'Berita Utama',
                'views' => 3120,
                'is_featured' => true,
                'published_at' => now()->subHours(12),
            ],
            [
                'category' => 'pid',
                'title' => 'Surat Edaran Peringatan Hari Guru Nasional & Puncak Acara HUT PGRI',
                'slug' => Str::slug('Surat Edaran Peringatan Hari Guru Nasional & Puncak Acara HUT PGRI'),
                'summary' => 'Instruksi pelaksanaan rangkaian kegiatan peringatan HGN dan HUT PGRI di tingkat Provinsi dan Kabupaten/Kota.',
                'content' => 'Diberitahukan kepada seluruh Pengurus PGRI Provinsi, Kabupaten/Kota, dan Ranting untuk menyelenggarakan Peringatan HUT PGRI dengan mengusung semangat solidaritas dan inovasi pendidikan.',
                'author' => 'Sekretariat PB PGRI',
                'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?auto=format&fit=crop&q=80&w=800',
                'badge' => 'Edaran Resmi',
                'views' => 2410,
                'is_featured' => false,
                'published_at' => now()->subDays(3),
            ],

            // Koding / KKA
            [
                'category' => 'koding_kka',
                'title' => 'Modul Koding & Berpikir Komputasional (KKA) untuk Guru SD dan SMP',
                'slug' => Str::slug('Modul Koding & Berpikir Komputasional KKA untuk Guru SD dan SMP'),
                'summary' => 'Panduan pengajaran dasar koding tanpa komputer (unplugged) dan dengan aplikasi visual Scratch untuk melatih logika berpikir komputasional.',
                'content' => 'Koding/KKA (Koding & Berpikir Komputasional) melatih 4 fondasi utama: dekomposisi, pengenalan pola, abstraksi, dan perancangan algoritma. Modul SAKTI KKA memberikan panduan step-by-step yang menyenangkan bagi siswa dan guru.',
                'author' => 'Ir. Hendra Wijaya, M.T.',
                'image' => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?auto=format&fit=crop&q=80&w=800',
                'file_url' => 'https://www.w3.org/WAI/ER/tests/xhtml/testfiles/resources/pdf/dummy.pdf',
                'badge' => 'Koding & AI',
                'views' => 3890,
                'is_featured' => true,
                'published_at' => now()->subHours(6),
            ],
            [
                'category' => 'koding_kka',
                'title' => 'Pemanfaatan Generative AI dalam Penyusunan Bahan Ajar Interaktif',
                'slug' => Str::slug('Pemanfaatan Generative AI dalam Penyusunan Bahan Ajar Interaktif'),
                'summary' => 'Teknik prompting etis dan efektif mengarahkan AI untuk membantu pembuatan soal, analisis materi, dan penyusunan kuis interaktif.',
                'content' => 'Artificial Intelligence (AI) adalah asisten bagi guru profesional. Dalam panduan ini, guru belajar cara merumuskan instruksi (prompting) cerdas agar AI dapat menghasilkan modul dan asesmen yang presisi.',
                'author' => 'Tim Siber & Teknologi PGRI',
                'image' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&q=80&w=800',
                'badge' => 'AI Guru',
                'views' => 2640,
                'is_featured' => false,
                'published_at' => now()->subDays(2),
            ],
        ];

        foreach ($saktiItems as $item) {
            SaktiContent::create($item);
        }

        // Galleries
        $galleries = [
            [
                'title' => 'Konferensi Kerja Nasional (Konkernas) PGRI XXI',
                'category' => 'Konferensi',
                'event_date' => '2026-08-15',
                'location' => 'Jakarta Convention Center (JCC)',
                'image' => 'https://images.unsplash.com/photo-1511578314322-379afb476865?auto=format&fit=crop&q=80&w=800',
                'description' => 'Pertemuan akbar perwakilan pengurus PGRI se-Indonesia membahas arah perjuangan organisasi dan transformasi digital SAKTI.',
            ],
            [
                'title' => 'Workshop Literasi Koding & AI untuk Guru Pembina',
                'category' => 'Workshop & Pelatihan',
                'event_date' => '2026-09-02',
                'location' => 'Gedung Guru PGRI Pusat',
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&q=80&w=800',
                'description' => 'Pelatihan intensif koding visual Scratch dan Artificial Intelligence dalam kelas bagi guru SD, SMP, dan SMA.',
            ],
            [
                'title' => 'Peringatan Hari Guru Nasional & Peluncuran Portal SAKTI',
                'category' => 'HUT PGRI & HGN',
                'event_date' => '2026-09-10',
                'location' => 'Stadion Gelora Bung Karno',
                'image' => 'https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&q=80&w=800',
                'description' => 'Perayaan puncak Hari Guru Nasional dan HUT PGRI yang dihadiri ribuan guru pendidik seluruh tanah air.',
            ],
            [
                'title' => 'Aksi Tanggap Bencana & Bantuan Peduli Kemanusiaan PGRI',
                'category' => 'Kemanusiaan & Sosial',
                'event_date' => '2026-09-18',
                'location' => 'Posko Peduli Guru PGRI',
                'image' => 'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?auto=format&fit=crop&q=80&w=800',
                'description' => 'Penyaluran bantuan sosial dan konseling pemulihan traumatis bagi guru dan siswa terdampak bencana.',
            ],
        ];

        foreach ($galleries as $gallery) {
            Gallery::create($gallery);
        }
    }
}
