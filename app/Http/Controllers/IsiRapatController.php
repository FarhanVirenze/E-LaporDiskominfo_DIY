<?php

namespace App\Http\Controllers;

use App\Models\IsiRapat;
use App\Models\Agenda;
use Illuminate\Http\Request;

class IsiRapatController extends Controller
{
   public function index()
{
    $isiRapats = IsiRapat::with(['agenda' => function($query) {
                            $query->where('status', 'disetujui');
                        }, 'user'])
                        ->whereHas('agenda', function($query) {
                            $query->where('status', 'disetujui');
                        })
                        ->get();

    return view('isi_rapats.index', compact('isiRapats'));
}

    public function create()
{
    $agendas = Agenda::where('status', 'disetujui')->get();

    return view('isi_rapats.form', [
        'isiRapat' => null,
        'agendas'  => $agendas,
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'id_agenda'   => 'required|exists:agendas,id_agenda',
            'pembahasan'  => 'required|string',
            'pic'         => 'required|string',
            'status'      => 'required|in:open,close',
        ]);

         $agenda = Agenda::find($request->id_agenda);
    if (!$agenda || $agenda->status !== 'disetujui') {
        return back()->withErrors(['id_agenda' => 'Agenda belum disetujui oleh pimpinan.']);
    }

        IsiRapat::create([
            'id_user'     => auth()->id(),
            'id_agenda'   => $request->id_agenda,
            'pembahasan'  => $request->pembahasan,
            'pic'         => $request->pic,
            'status'      => $request->status,
        ]);

        return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil ditambahkan.');
    }

    public function close(IsiRapat $isi_rapat)
{
    if (auth()->user()->role !== 'admin') abort(403);
    $isi_rapat->update(['status' => 'close']);
    return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil ditutup.');
}

public function reopen(IsiRapat $isi_rapat)
{
    if (auth()->user()->role !== 'admin') abort(403);
    $isi_rapat->update(['status' => 'open']);
    return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil dibuka kembali.');
}

    public function edit(IsiRapat $isi_rapat)
    {
        $agendas = Agenda::all();

        return view('isi_rapats.form', [
            'isiRapat' => $isi_rapat,
            'agendas'  => $agendas,
        ]);
    }

    public function update(Request $request, IsiRapat $isi_rapat)
    {
        $request->validate([
            'id_agenda'   => 'required|exists:agendas,id_agenda',
            'pembahasan'  => 'required|string',
            'pic'         => 'required|string',
            'status'      => 'required|in:open,close',
        ]);

        $isi_rapat->update([
            'id_agenda'   => $request->id_agenda,
            'pembahasan'  => $request->pembahasan,
            'pic'         => $request->pic,
            'status'      => $request->status,
        ]);

        return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil diperbarui.');
    }

    public function destroy(IsiRapat $isi_rapat)
    {
        $isi_rapat->delete();
        return redirect()->route('isi_rapats.index')->with('success', 'Isi rapat berhasil dihapus.');
    }
}
