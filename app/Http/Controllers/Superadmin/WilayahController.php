<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Wilayah;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    public function index()
    {
        $wilayah = Wilayah::all();
        return view('superadmin.wilayah.index', compact('wilayah'));
    }

    public function create()
    {
        return view('superadmin.wilayah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:wilayah,nama',
        ]);

        Wilayah::create([
            'nama' => $request->nama,
        ]);

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil ditambahkan.');
    }

    public function edit(string $id)
    {
        $wilayah = Wilayah::findOrFail($id);
        return view('superadmin.wilayah.edit', compact('wilayah'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:wilayah,nama,' . $id,
        ]);

        $wilayah = Wilayah::findOrFail($id);
        $wilayah->update([
            'nama' => $request->nama,
        ]);

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $wilayah = Wilayah::findOrFail($id);
        $wilayah->delete();

        return redirect()->route('wilayah.index')->with('success', 'Wilayah berhasil dihapus.');
    }
}
