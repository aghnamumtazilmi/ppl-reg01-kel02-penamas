<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

/**
 * Class UserController
 *
 * Menangani logika Backend API & Tampilan Web untuk Fitur F-01: Kelola Akun Pengguna (Sprint 1)
 * PIC: Riyan Saefuloh
 */
class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna dengan fitur pencarian dan filter peran.
     *
     * Web Route: GET /users
     * API Route: GET /api/users
     */
    public function index(Request $request): View|JsonResponse
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

        $perPage = (int) $request->input('per_page', 10);
        $users = $query->latest()->paginate($perPage)->withQueryString();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Daftar pengguna berhasil dimuat.',
                'data' => $users,
            ], 200);
        }

        // Data statistik ringkas untuk kartu dashboard web
        $stats = [
            'total' => User::count(),
            'pimpinan' => User::where('role', 'pimpinan')->count(),
            'admin' => User::where('role', 'admin')->count(),
            'petugas' => User::where('role', 'petugas')->count(),
        ];

        return view('users.index', compact('users', 'stats'));
    }

    /**
     * Menampilkan formulir pendaftaran akun baru (Frontend Web).
     *
     * Web Route: GET /users/create
     */
    public function create(): View
    {
        return view('users.create');
    }

    /**
     * PBI-001: Register & Role (Pendaftaran Akun Baru)
     * Mendaftarkan akun pengguna baru beserta peran/hak akses yang ditentukan.
     *
     * Web Route: POST /users
     * API Route: POST /api/users
     */
    public function store(StoreUserRequest $request): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Pengguna baru {$user->name} dengan peran '{$user->role}' berhasil didaftarkan.",
                'data' => $user,
            ], 201);
        }

        return redirect()->route('users.index')
            ->with('success', "Akun pengguna {$user->name} berhasil didaftarkan ke sistem.");
    }

    /**
     * Menampilkan data detail satu akun pengguna.
     *
     * API Route: GET /api/users/{id}
     * Web Route: diarahkan ke halaman edit
     */
    public function show(Request $request, User $user): RedirectResponse|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Detail data pengguna berhasil dimuat.',
                'data' => $user,
            ], 200);
        }

        return redirect()->route('users.edit', $user);
    }

    /**
     * Menampilkan formulir ubah data & hak akses pengguna (Frontend Web).
     *
     * Web Route: GET /users/{id}/edit
     */
    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    /**
     * PBI-002: Ubah Data & Hak Akses (Edit Profil & Peran)
     * Memperbarui profil pengguna dan hak akses/peran (role).
     *
     * Web Route: PUT /users/{id}
     * API Route: PUT/PATCH /api/users/{id}
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse|JsonResponse
    {
        $validated = $request->validated();

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        // Jika password diisi, hash kata sandi baru
        if (!empty($validated['password'])) {
            $data['password'] = Hash::make($validated['password']);
        }

        $user->update($data);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Data dan hak akses pengguna {$user->name} berhasil diperbarui.",
                'data' => $user->fresh(),
            ], 200);
        }

        return redirect()->route('users.index')
            ->with('success', "Data dan hak akses akun {$user->name} berhasil diperbarui.");
    }

    /**
     * PBI-003: Hapus Akun Pengguna
     * Menghapus akun pengguna dari sistem.
     *
     * Web Route: DELETE /users/{id}
     * API Route: DELETE /api/users/{id}
     */
    public function destroy(Request $request, User $user): RedirectResponse|JsonResponse
    {
        // 1. Proteksi: cegah pengguna menghapus akunnya sendiri yang sedang aktif login
        if (auth()->check() && auth()->id() === $user->id) {
            $msg = 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 403);
            }

            return redirect()->route('users.index')->with('error', $msg);
        }

        // 2. Proteksi: akun Pimpinan dilindungi oleh sistem dan tidak dapat dihapus
        if ($user->role === 'pimpinan') {
            $msg = 'Akun Pimpinan dilindungi oleh sistem dan tidak dapat dihapus.';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $msg,
                ], 403);
            }

            return redirect()->route('users.index')->with('error', $msg);
        }

        $userName = $user->name;
        $user->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Akun pengguna {$userName} berhasil dihapus dari sistem.",
            ], 200);
        }

        return redirect()->route('users.index')
            ->with('success', "Akun pengguna {$userName} berhasil dihapus dari sistem.");
    }
}
