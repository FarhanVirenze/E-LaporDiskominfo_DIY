<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\User;
use App\Models\Ruangan;
use App\Models\IsiRapat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index() {
        $agendas = Agenda::with(['user', 'ruangan', 'approvedBy', 'pic'])->get();
        return view('agendas.index', compact('agendas'));
    }

    public function create() {
        if (Auth::user()->role !== 'admin') abort(403);

        $ruangans = Ruangan::all();
        $pic_users = User::whereIn('role', ['user'])->get(); // Atur sesuai role yang boleh jadi PIC
        return view('agendas.form', compact('ruangans', 'pic_users'));
    }

    public function store(Request $request) {
    if (Auth::user()->role !== 'admin') abort(403);

    $request->validate([
        'nm_agenda' => 'required|string|max:255',
        'tanggal' => 'required|date',
        'waktu' => 'required',
        'deskripsi' => 'nullable',
        'id_ruangan' => 'required|exists:ruangans,id_ruangan',
        'id_pic' => 'nullable|exists:users,id_user',
    ]);

    // Simpan agenda baru
    $agenda = Agenda::create([
        'id_user' => Auth::user()->id_user,
        'id_ruangan' => $request->id_ruangan,
        'nm_agenda' => $request->nm_agenda,
        'tanggal' => $request->tanggal,
        'waktu' => $request->waktu,
        'deskripsi' => $request->deskripsi,
        'id_pic' => $request->id_pic,
        'status' => 'diajukan',
    ]);

    // Buat data isi_rapat secara otomatis
    IsiRapat::create([
        'id_user' => Auth::user()->id_user,
        'id_agenda' => $agenda->id_agenda,
        'pembahasan' => '',
        'pic' => $request->id_pic ? User::find($request->id_pic)->name : '-',
        'status' => 'open',
    ]);

    return redirect()->route('agendas.index')->with('success', 'Agenda dan Isi Rapat berhasil dibuat.');
}

    public function edit(Agenda $agenda) {
        if (Auth::user()->role !== 'admin') abort(403);

        $ruangans = Ruangan::all();
        $pic_users = User::whereIn('role', ['user', 'admin'])->get();
        return view('agendas.form', compact('agenda', 'ruangans', 'pic_users'));
    }

    public function update(Request $request, Agenda $agenda) {
        if (Auth::user()->role !== 'admin') abort(403);

        $request->validate([
            'id_user' => 'required|exists:users,id_user',
            'id_ruangan' => 'required|exists:ruangans,id_ruangan',
            'nm_agenda' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'deskripsi' => 'nullable',
            'id_pic' => 'nullable|exists:users,id_user',
        ]);

        $agenda->update([
            'id_user' => $request->id_user,
            'id_ruangan' => $request->id_ruangan,
            'nm_agenda' => $request->nm_agenda,
            'tanggal' => $request->tanggal,
            'waktu' => $request->waktu,
            'deskripsi' => $request->deskripsi,
            'id_pic' => $request->id_pic,
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Agenda $agenda) {
        if (Auth::user()->role !== 'admin') abort(403);

        $agenda->delete();
        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil dihapus.');
    }

    public function approve(Agenda $agenda) {
        if (Auth::user()->role !== 'pimpinan') {
            abort(403, 'Hanya pimpinan yang dapat menyetujui agenda.');
        }

        $agenda->update([
            'status' => 'disetujui',
            'approved_by' => Auth::user()->id_user,
            'approved_at' => Carbon::now(),
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda berhasil disetujui.');
    }

    public function reject(Agenda $agenda) {
        if (Auth::user()->role !== 'pimpinan') {
            abort(403, 'Hanya pimpinan yang dapat menolak agenda.');
        }

        $agenda->update([
            'status' => 'ditolak',
            'approved_by' => Auth::user()->id_user,
            'approved_at' => Carbon::now(),
        ]);

        return redirect()->route('agendas.index')->with('success', 'Agenda ditolak.');
    }
}
