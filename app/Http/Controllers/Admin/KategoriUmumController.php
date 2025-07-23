<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KategoriUmum;
use Illuminate\Http\Request;

class KategoriUmumController extends Controller
{
    public function index()
    {
        $kategori = KategoriUmum::paginate(5); // Paginate 5 entries per page
        return view('admin.kategori_umum.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        KategoriUmum::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kelola-kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $kategori = KategoriUmum::findOrFail($id);
        $kategori->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kelola-kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriUmum::findOrFail($id);
        $kategori->delete();

        return redirect()->route('admin.kelola-kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
