<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Executive;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminExecutiveController extends Controller
{
    public function index()
    {
        $executives = Executive::orderBy('order', 'asc')->get();
        return view('admin.executives.index', compact('executives'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:1000',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
            'order_index' => 'nullable|integer',
        ]);

        // Normalize unit / department
        $unit = !empty($validated['unit']) ? $validated['unit'] : (!empty($validated['department']) ? $validated['department'] : 'Pengurus Besar');
        $validated['unit'] = $unit;

        // Normalize order
        $order = isset($validated['order']) ? $validated['order'] : (isset($validated['order_index']) ? $validated['order_index'] : (Executive::max('order') + 1));
        $validated['order'] = $order;

        // Handle Photo Upload
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'executive_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('executives', $filename, 'public');
            $validated['photo'] = '/storage/' . $path;
        } elseif (empty($validated['photo'])) {
            $validated['photo'] = 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=400';
        }

        Executive::create($validated);

        return redirect()->route('admin.executives.index')->with('success', 'Data pengurus PGRI berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $executive = Executive::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'unit' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'photo' => 'nullable|string|max:1000',
            'photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'bio' => 'nullable|string',
            'order' => 'nullable|integer',
            'order_index' => 'nullable|integer',
        ]);

        // Normalize unit / department
        if (!empty($validated['unit'])) {
            $validated['unit'] = $validated['unit'];
        } elseif (!empty($validated['department'])) {
            $validated['unit'] = $validated['department'];
        }

        // Normalize order
        if (isset($validated['order'])) {
            $validated['order'] = $validated['order'];
        } elseif (isset($validated['order_index'])) {
            $validated['order'] = $validated['order_index'];
        }

        // Handle Photo Upload
        if ($request->hasFile('photo_file')) {
            $file = $request->file('photo_file');
            $filename = 'executive_' . time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('executives', $filename, 'public');
            $validated['photo'] = '/storage/' . $path;
        }

        $executive->update($validated);

        return redirect()->route('admin.executives.index')->with('success', 'Data pengurus berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $executive = Executive::findOrFail($id);
        $executive->delete();

        return redirect()->route('admin.executives.index')->with('success', 'Pengurus berhasil dihapus!');
    }
}
