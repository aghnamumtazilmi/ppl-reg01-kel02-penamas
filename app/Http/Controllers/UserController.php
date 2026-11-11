<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Class UserController
 *
 * Menangani logika Backend API untuk Fitur F-01: Kelola Akun Pengguna (Sprint 1)
 * PIC: Riyan Saefuloh
 */
class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna dengan fitur pencarian dan filter peran.
     *
     * Endpoint: GET /api/users
     * Query params:
     * - search: pencarian nama atau email
     * - role: filter role ('pimpinan', 'admin', 'petugas')
     * - per_page: jumlah item per halaman (default 10)
     */
    public function index(Request $request): JsonResponse
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
        $users = $query->latest()->paginate($perPage);

        return response()->json([
            'success' => true,
            'message' => 'Daftar pengguna berhasil dimuat.',
            'data' => $users,
        ], 200);
    }

    /**
     * PBI-001: Register & Role (Pendaftaran Akun Baru)
     * Mendaftarkan akun pengguna baru beserta peran/hak akses yang ditentukan.
     *
     * Endpoint: POST /api/users
     * Payload: name, email, password, password_confirmation, role
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        return response()->json([
            'success' => true,
            'message' => "Pengguna baru {$user->name} dengan peran '{$user->role}' berhasil didaftarkan.",
            'data' => $user,
        ], 201);
    }

    /**
     * Menampilkan data detail satu akun pengguna.
     *
     * Endpoint: GET /api/users/{id}
     */
    public function show(User $user): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail data pengguna berhasil dimuat.',
            'data' => $user,
        ], 200);
    }

    /**
     * PBI-002: Ubah Data & Hak Akses (Edit Profil & Peran)
     * Memperbarui profil pengguna dan hak akses/peran (role).
     *
     * Endpoint: PUT/PATCH /api/users/{id}
     * Payload: name, email, role, password (opsional), password_confirmation (opsional)
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
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

        return response()->json([
            'success' => true,
            'message' => "Data dan hak akses pengguna {$user->name} berhasil diperbarui.",
            'data' => $user->fresh(),
        ], 200);
    }

    /**
     * PBI-003: Hapus Akun Pengguna
     * Menghapus akun pengguna dari sistem.
     *
     * Endpoint: DELETE /api/users/{id}
     */
    public function destroy(User $user): JsonResponse
    {
        // Proteksi: cegah pengguna menghapus akunnya sendiri yang sedang aktif login
        if (auth()->check() && auth()->id() === $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif digunakan.',
            ], 403);
        }

        $userName = $user->name;
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => "Akun pengguna {$userName} berhasil dihapus dari sistem.",
        ], 200);
    }
}
