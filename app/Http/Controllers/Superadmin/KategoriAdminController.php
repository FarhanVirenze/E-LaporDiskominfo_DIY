<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\KategoriUmum;
use App\Models\User;

class KategoriAdminController extends Controller
{
    // Tampilkan daftar kategori dan admin yang tersedia
    public function index()
    {
        $admins = User::with('kategori')
            ->where('role', 'admin')
            ->paginate(5); // <--- Tambahkan pagination

        $kategoris = KategoriUmum::all();

        return view('superadmin.kategori-admin.index', compact('admins', 'kategoris'));
    }

    // Update admin_id dari kategori tertentu
    public function update(Request $request, $admin_id)
    {
        $request->validate([
            'kategori_ids' => 'array', // Boleh kosong
            'kategori_ids.*' => 'exists:kategori_umum,id',
        ]);

        // Ambil semua ID kategori yang dikirim dari form
        $kategoriIds = $request->input('kategori_ids', []);

        // Step 1: Hapus semua kategori milik admin ini
        KategoriUmum::where('admin_id', $admin_id)->update(['admin_id' => null]);

        // Step 2: Assign kembali kategori yang dipilih
        if (!empty($kategoriIds)) {
            KategoriUmum::whereIn('id', $kategoriIds)->update(['admin_id' => $admin_id]);
        }

        return redirect()->route('superadmin.kategori-admin.index')
            ->with('success', 'Kategori admin berhasil diperbarui.');
    }
}
