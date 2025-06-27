<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index() {
        $ruangans = Ruangan::all();
        return view('ruangans.index', compact('ruangans'));
    }

    public function create() {
        return view('ruangans.form');
    }

    public function store(Request $request) {
        $request->validate([
            'nm_ruangan' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
        ]);

        Ruangan::create([
            'nm_ruangan' => $request->nm_ruangan,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil ditambahkan.');
    }

    public function edit(Ruangan $ruangan) {
        return view('ruangans.form', compact('ruangan'));
    }

    public function update(Request $request, Ruangan $ruangan) {
        $request->validate([
            'nm_ruangan' => 'required|string|max:255',
            'lokasi' => 'nullable|string|max:255',
            'kapasitas' => 'nullable|integer|min:1',
        ]);

        $ruangan->update([
            'nm_ruangan' => $request->nm_ruangan,
            'lokasi' => $request->lokasi,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil diperbarui.');
    }

    public function destroy(Ruangan $ruangan) {
        $ruangan->delete();
        return redirect()->route('ruangans.index')->with('success', 'Ruangan berhasil dihapus.');
    }
}
