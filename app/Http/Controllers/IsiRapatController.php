<?php

namespace App\Http\Controllers;

use App\Models\IsiRapat;
use App\Models\Agenda;
use Illuminate\Http\Request;

class IsiRapatController extends Controller
{
    public function index()
{
    $isiRapats = IsiRapat::with([
        'agenda.pic', // tambahkan ini agar relasi pic juga dimuat
        'user',
    ])
    ->whereHas('agenda', function ($query) {
        $query->where('status', 'disetujui');
    })
    ->get();

    return view('isi_rapats.index', compact('isiRapats'));
}

    public function create()
    {
        if (auth()->user()->role !== 'user')
            abort(403);

        // Ambil agenda yang disetujui dan user login sebagai PIC-nya
        $agendas = Agenda::where('status', 'disetujui')
            ->where('id_pic', auth()->id())
            ->get();

        return view('isi_rapats.form', [
            'isiRapat' => null,
            'agendas' => $agendas,
        ]);
    }

   public function store(Request $request)
{
    if (auth()->user()->role !== 'user') abort(403);

    $request->validate([
        'id_agenda' => 'required|exists:agendas,id_agenda',
        'pembahasan' => 'required|string',
    ]);

    // Cek agenda yang valid dan dimiliki user sebagai PIC
    $agenda = Agenda::where('id_agenda', $request->id_agenda)
        ->where('status', 'disetujui')
        ->where('id_pic', auth()->id())
        ->first();

    if (!$agenda) {
        return back()->withErrors(['id_agenda' => 'Agenda tidak valid atau bukan milik Anda.'])->withInput();
    }

    // Cek apakah user sudah mengisi isi rapat untuk agenda ini
    $existingIsi = IsiRapat::where('id_agenda', $request->id_agenda)
        ->where('id_user', auth()->id())
        ->first();

    if ($existingIsi) {
        return back()->withErrors([
            'id_agenda' => 'Anda sudah menambahkan isi rapat untuk agenda ini.'
        ])->withInput();
    }

    // Simpan isi rapat
    IsiRapat::create([
        'id_user' => auth()->id(),
        'id_agenda' => $agenda->id_agenda,
        'pembahasan' => $request->pembahasan,
        'status' => 'open',
    ]);

    return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil ditambahkan.');
}
    public function close(IsiRapat $isi_rapat)
    {
        if (auth()->user()->role !== 'admin')
            abort(403);
        $isi_rapat->update(['status' => 'close']);
        return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil ditutup.');
    }

    public function reopen(IsiRapat $isi_rapat)
    {
        if (auth()->user()->role !== 'admin')
            abort(403);
        $isi_rapat->update(['status' => 'open']);
        return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil dibuka kembali.');
    }

    public function edit(IsiRapat $isi_rapat)
    {
        if (auth()->user()->role === 'user') {
            if (auth()->id() !== $isi_rapat->id_user || $isi_rapat->status !== 'open') {
                abort(403);
            }
        } elseif (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $agendas = Agenda::all();

        return view('isi_rapats.form', [
            'isiRapat' => $isi_rapat,
            'agendas' => $agendas,
        ]);
    }

    public function update(Request $request, IsiRapat $isi_rapat)
    {
        if (auth()->user()->role !== 'user' || auth()->id() !== $isi_rapat->id_user || $isi_rapat->status !== 'open') {
            abort(403);
        }

        $request->validate([
            'pembahasan' => 'required|string',
        ]);

        $isi_rapat->update([
            'pembahasan' => $request->pembahasan,
        ]);

        return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil diperbarui.');
    }
    public function destroy(IsiRapat $isi_rapat)
    {
        if (auth()->user()->role !== 'admin')
            abort(403);

        $isi_rapat->delete();
        return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil dihapus.');
    }
}
