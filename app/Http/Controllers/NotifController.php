<?php

namespace App\Http\Controllers;

use App\Models\Notif;
use App\Models\User;
use Illuminate\Http\Request;

class NotifController extends Controller
{
    public function index()
    {
        $notifs = Notif::with('user')->latest()->get();
        return view('notifs.index', compact('notifs'));
    }

    public function create()
    {
        $users = User::all();
        return view('notifs.form', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user'       => 'required|exists:users,id_user',
            'jenis_notif'   => 'required|string',
            'keterangan'    => 'required|string',
            'status'        => 'required|in:terbaca,belum terbaca',
            'tanggal'       => 'required|date',
            'waktu'         => 'required|date_format:H:i',
        ]);

        Notif::create([
            'id_user'       => $request->id_user,
            'jenis_notif'   => $request->jenis_notif,
            'keterangan'    => $request->keterangan,
            'status'        => $request->status,
            'tanggal'       => $request->tanggal,
            'waktu'         => $request->waktu,
        ]);

        return redirect()->route('notifs.index')->with('success', 'Notifikasi berhasil ditambahkan.');
    }

    public function edit(Notif $notif)
    {
        $users = User::all();
        return view('notifs.form', compact('notif', 'users'));
    }

    public function update(Request $request, Notif $notif)
    {
        $request->validate([
            'id_user'       => 'required|exists:users,id_user',
            'jenis_notif'   => 'required|string',
            'keterangan'    => 'required|string',
            'status'        => 'required|in:terbaca,belum terbaca',
            'tanggal'       => 'required|date',
            'waktu'         => 'required|date_format:H:i',
        ]);

        $notif->update([
            'id_user'       => $request->id_user,
            'jenis_notif'   => $request->jenis_notif,
            'keterangan'    => $request->keterangan,
            'status'        => $request->status,
            'tanggal'       => $request->tanggal,
            'waktu'         => $request->waktu,
        ]);

        return redirect()->route('notifs.index')->with('success', 'Notifikasi berhasil diperbarui.');
    }

    public function destroy(Notif $notif)
    {
        $notif->delete();
        return redirect()->route('notifs.index')->with('success', 'Notifikasi berhasil dihapus.');
    }
}
