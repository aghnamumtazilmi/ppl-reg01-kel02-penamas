<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan daftar semua pengguna dengan fitur pencarian dan filter peran.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Fitur Pencarian berdasarkan nama atau email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Fitur Filter berdasarkan Role (pimpinan, admin, petugas)
        if ($request->filled('role')) {
            $query->where('role', $request->input('role'));
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     * PBI-001: Form untuk registrasi/tambah akun baru beserta pilihan role.
     */
    public function create()
    {
        $roles = [
            'petugas' => 'Petugas Lapangan',
            'admin' => 'Administrator',
            'pimpinan' => 'Pimpinan',
        ];

        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * PBI-001: Simpan akun baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:pimpinan,admin,petugas'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar di sistem.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required' => 'Pilihan peran (role) wajib ditentukan.',
            'role.in' => 'Peran yang dipilih tidak valid.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('users.index')
            ->with('success', "Akun pengguna {$validated['name']} berhasil ditambahkan.");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return redirect()->route('users.edit', $user);
    }

    /**
     * Show the form for editing the specified resource.
     * PBI-002: Form ubah data profil dan hak akses (role).
     */
    public function edit(User $user)
    {
        $roles = [
            'petugas' => 'Petugas Lapangan',
            'admin' => 'Administrator',
            'pimpinan' => 'Pimpinan',
        ];

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     * PBI-002: Simpan perubahan data profil dan perbarui hak akses pengguna.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'string', 'in:pimpinan,admin,petugas'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh pengguna lain.',
            'password.min' => 'Kata sandi minimal terdiri dari 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'role.required' => 'Peran (role) wajib ditentukan.',
            'role.in' => 'Peran yang dipilih tidak valid.',
        ]);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Jika password diisi, ubah password pengguna
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        return redirect()->route('users.index')
            ->with('success', "Data pengguna {$user->name} berhasil diperbarui.");
    }

    /**
     * Remove the specified resource from storage.
     * PBI-003: Hapus akun pengguna dari sistem.
     */
    public function destroy(User $user)
    {
        // Proteksi jika user yang login mencoba menghapus akunnya sendiri
        if (auth()->check() && auth()->id() === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', "Akun pengguna {$userName} berhasil dihapus.");
    }
}
