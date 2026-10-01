<?php

namespace App\Http\Controllers;

use App\Models\Executive;
use App\Models\Gallery;
use App\Models\SaktiContent;
use App\Models\Testimonial;
use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredSakti = SaktiContent::featured()->latest('published_at')->take(4)->get();
        
        $deepLearning = SaktiContent::category('pembelajaran_mendalam')->latest('published_at')->take(3)->get();
        $rumahPendidikan = SaktiContent::category('rumah_pendidikan')->latest('published_at')->take(3)->get();
        $latestPid = SaktiContent::category('pid')->latest('published_at')->take(3)->get();
        $latestKoding = SaktiContent::category('koding_kka')->latest('published_at')->take(3)->get();
        
        $executives = Executive::active()->take(4)->get();
        $galleries = Gallery::latest('event_date')->take(6)->get();
        $testimonials = Testimonial::active()->orderBy('order', 'asc')->get();
        $latestNews = News::latestPublished()->take(3)->get();

        $stats = [
            'total_guru' => '3.4M+',
            'total_ranting' => '514 Kota/Kab',
            'total_kegiatan' => '1.200+ Event',
            'total_modul' => '500+ Modul',
        ];

        return view('home', compact(
            'featuredSakti',
            'deepLearning',
            'rumahPendidikan',
            'latestPid',
            'latestKoding',
            'executives',
            'galleries',
            'testimonials',
            'latestNews',
            'stats'
        ));
    }
}
