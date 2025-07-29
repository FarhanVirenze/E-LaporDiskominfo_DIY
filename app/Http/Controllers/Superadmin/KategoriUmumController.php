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

        if ($request->has('search') && $request->search != '') {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $kategori = $query->paginate(5)->appends($request->all()); // tetap paginasi

        return view('superadmin.kategori_umum.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        KategoriUmum::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('superadmin.kelola-kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
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

        return redirect()->route('superadmin.kelola-kategori.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $kategori = KategoriUmum::findOrFail($id);
        $kategori->delete();

        return redirect()->route('superadmin.kelola-kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
