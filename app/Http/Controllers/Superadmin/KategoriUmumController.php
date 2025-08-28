<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\KategoriUmum;
use Illuminate\Http\Request;

class KategoriUmumController extends Controller
{
    public function index(Request $request)
    {
        $query = KategoriUmum::query();

        // 🔎 Filter pencarian
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        // 🔎 Filter berdasarkan tipe
        if ($request->filled('tipe')) {
            $query->where('tipe', $request->tipe);
        }

        $kategori = $query->paginate(5)->appends($request->all());

        return view('superadmin.kategori_umum.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:wbs_admin,non_wbs_admin',
        ]);

        KategoriUmum::create($request->only(['nama', 'tipe']));

        return redirect()->route('superadmin.kelola-kategori.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'tipe' => 'required|in:wbs_admin,non_wbs_admin',
        ]);

        $kategori = KategoriUmum::findOrFail($id);
        $kategori->update($request->only(['nama', 'tipe']));

        return redirect()->route('superadmin.kelola-kategori.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriUmum::findOrFail($id);
        $kategori->delete();

        return redirect()->route('superadmin.kelola-kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
