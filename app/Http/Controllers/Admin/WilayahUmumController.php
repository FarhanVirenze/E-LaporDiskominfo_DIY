<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WilayahUmum;
use Illuminate\Http\Request;

class WilayahUmumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wilayah = WilayahUmum::paginate(5); // Paginate 5 entries per page
        return view('admin.wilayah_umum.index', compact('wilayah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        WilayahUmum::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kelola-wilayah.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        // Menemukan wilayah berdasarkan ID dan melakukan update
        $wilayah = WilayahUmum::findOrFail($id);
        $wilayah->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('admin.kelola-wilayah.index')->with('success', 'Wilayah berhasil diperbarui.');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $wilayah = WilayahUmum::findOrFail($id);
        $wilayah->delete();

        return redirect()->route('admin.kelola-wilayah.index')->with('success', 'Wilayah berhasil dihapus.');
    }
}
