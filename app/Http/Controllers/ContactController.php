<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\Setting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $office = [
            'name' => 'Pengurus Besar PGRI / Sekretariat Organisasi',
            'address' => Setting::get('office_address', 'Jl. Tanah Abang III No. 24, Gambir, Jakarta Pusat, DKI Jakarta 10160'),
            'phone' => Setting::get('office_phone', '(021) 3844932 / 3846665'),
            'email' => Setting::get('office_email', 'sekretariat@pgri.or.id'),
            'whatsapp' => Setting::get('office_whatsapp', '0812-3456-7890'),
            'hours' => Setting::get('office_hours', 'Senin - Jumat: 08:00 - 16:00 WIB'),
        ];

        return view('contact', compact('office'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'school_unit' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        return redirect()->route('contact.index')->with('success', 'Terima kasih! Pesan/Aspirasi Anda berhasil dikirim ke Pengurus PGRI.');
    }
}
