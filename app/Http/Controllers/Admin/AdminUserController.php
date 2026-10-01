<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    private function ensureAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses Ditolak: Menu Kelola Akun hanya dapat diakses oleh Administrator.');
        }
    }
    public function index(Request $request)
    {
        $this->ensureAdmin();
        $role = $request->input('role');
        $search = $request->input('search');

        $query = User::orderBy('id', 'desc');

        if (!empty($role) && in_array($role, ['admin', 'pengurus', 'guru'])) {
            $query->where('role', $role);
        }

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('school_origin', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate(10)->withQueryString();

        $totalUsers = User::count();
        $totalAdmins = User::where('role', 'admin')->count();
        $totalPengurus = User::where('role', 'pengurus')->count();
        $totalGuru = User::where('role', 'guru')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'totalPengurus',
            'totalGuru',
            'role',
            'search'
        ));
    }

    public function create()
    {
        $this->ensureAdmin();
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->ensureAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,pengurus,guru',
            'phone' => 'nullable|string|max:50',
            'school_origin' => 'nullable|string|max:255',
            'is_active' => 'nullable',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'] ?? null,
            'school_origin' => $validated['school_origin'] ?? null,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna (' . ucfirst($validated['role']) . ') berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $this->ensureAdmin();
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureAdmin();
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,pengurus,guru',
            'phone' => 'nullable|string|max:50',
            'school_origin' => 'nullable|string|max:255',
            'is_active' => 'nullable',
        ]);

        // Security check: cannot deactivate or remove admin from own account
        if (Auth::id() == $id) {
            if (!$request->has('is_active')) {
                return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
            }
            if ($validated['role'] !== 'admin' && Auth::user()->role === 'admin') {
                return back()->with('error', 'Anda tidak dapat menurunkan peran (role) akun admin Anda sendiri!');
            }
        }

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        $user->phone = $validated['phone'] ?? null;
        $user->school_origin = $validated['school_origin'] ?? null;
        $user->is_active = $request->has('is_active');

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data akun pengguna berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $this->ensureAdmin();
        if (Auth::id() == $id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang digunakan!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil dihapus!');
    }

    public function toggleStatus($id)
    {
        $this->ensureAdmin();
        if (Auth::id() == $id) {
            return back()->with('error', 'Anda tidak dapat menonaktifkan akun Anda sendiri!');
        }

        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();

        $statusText = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.users.index')->with('success', "Akun {$user->name} berhasil {$statusText}!");
    }
}
