<?php

namespace App\Http\Controllers\WbsAdmin;

use App\Http\Controllers\Controller;
use App\Models\WbsReport;
use App\Models\Report;
use App\Models\WbsFollowUp;
use App\Models\WbsComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WbsAduanController extends Controller
{
    // Menampilkan semua laporan
    public function index(Request $request)
    {
        $wbsAdmin = Auth::user(); // WBS Admin login

        $query = WbsReport::with(['kategori', 'wilayah', 'pelapor']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->orderByDesc('created_at')
            ->paginate(10)
            ->appends($request->query());

        return view('wbs_admin.aduan.index', compact('reports'));
    }

    // Menampilkan detail laporan beserta follow up & comments
    public function show($id)
    {
        $report = WbsReport::with([
            'kategori',
            'wilayah',
            'pelapor',
            'followUps.user',
            'comments.user',
        ])->findOrFail($id);

        if ($report->status === 'Diajukan') {
            $report->status = 'Dibaca';
            $report->save();

            session()->flash('success', 'Status laporan otomatis berubah menjadi Dibaca.');
        }

        return view('wbs_admin.detail.index', compact('report'));
    }

    // Simpan tindak lanjut (follow up)
    public function storeFollowUp(Request $request, $reportId)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        $report = WbsReport::findOrFail($reportId);

        // Upload lampiran jika ada
        $lampiran = null;
        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran')->store('wbs_followups', 'public');
        }

        // Simpan follow-up
        WbsFollowUp::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(), // user admin yg follow up
            'deskripsi' => $request->deskripsi,
            'lampiran' => $lampiran,
        ]);

        // Ubah status laporan otomatis jika belum "Selesai"
        if ($report->status !== 'Selesai') {
            $report->status = 'Direspon';
            $report->save();
        }

        return redirect()->back()->with('success', 'Tindak lanjut berhasil ditambahkan, Status berubah menjadi Direspon');
    }

    // Simpan komentar
    public function storeComment(Request $request, $reportId)
    {
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $report = WbsReport::findOrFail($reportId);

        $file = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('wbs_comments', 'public');
        }

        WbsComment::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(), // user yg komentar
            'pesan' => $request->pesan,
            'file' => $file,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil ditambahkan.');
    }

    // Update komentar
    public function updateComment(Request $request, $id)
    {
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|max:2048',
        ]);

        $comment = WbsComment::findOrFail($id);

        $file = $comment->file;
        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('wbs_comments', 'public');
        }

        $comment->update([
            'pesan' => $request->pesan,
            'file' => $file,
        ]);

        return redirect()->back()->with('success', 'Komentar berhasil diperbarui.');
    }

    // Hapus komentar
    public function destroyComment($id)
    {
        $comment = WbsComment::findOrFail($id);
        $comment->delete();

        return redirect()->back()->with('success', 'Komentar berhasil dihapus.');
    }

    // Update field tertentu
    public function update(Request $request, $id)
    {
        $report = WbsReport::findOrFail($id);

        $field = $request->input('field');
        $value = $request->input('value');

        $rules = [
            'status' => 'required|in:' . implode(',', WbsReport::getStatuses()),
            'kategori_id' => 'required|exists:kategori_umum,id',
            'wilayah_id' => 'required|exists:wilayah_umum,id',
            'waktu_kejadian' => 'required|date',
            'nama_terlapor' => 'required|string|max:255',
            'lokasi_kejadian' => 'required|string|max:100',
            'uraian' => 'required|string',
            'tracking_id' => 'required|string|max:50',
            'lampiran.*' => 'file|max:2048|mimes:jpg,jpeg,png,gif,pdf,doc,docx',
        ];

        // === Update lokasi & uraian sekaligus ===
        if ($field === 'lokasi_uraian') {
            $request->validate([
                'lokasi_kejadian' => $rules['lokasi_kejadian'],
                'uraian' => $rules['uraian'],
            ]);

            $report->lokasi_kejadian = $request->lokasi_kejadian;
            $report->uraian = $request->uraian;
            $report->save();

            return redirect()->back()->with('success', 'Lokasi & Uraian berhasil diperbarui.');
        }

        // === Tambah lampiran ===
        if ($field === 'lampiran') {
            $request->validate([
                'lampiran.*' => 'file|max:2048|mimes:jpg,jpeg,png,gif,pdf,doc,docx',
            ]);

            if ($request->hasFile('lampiran')) {
                $newFiles = [];
                foreach ($request->file('lampiran') as $file) {
                    $path = $file->store('lampiran', 'public');
                    $newFiles[] = $path;
                }

                // gabung dengan lampiran lama
                $report->lampiran = array_merge($report->lampiran ?? [], $newFiles);
                $report->save();
            }

            return redirect()->back()->with('success', 'Lampiran berhasil diperbarui.');
        }

        // === Hapus lampiran tertentu ===
        if ($field === 'hapus_lampiran') {
            $file = $request->input('file');
            $lampiran = $report->lampiran ?? [];

            // hapus dari array
            $lampiran = array_filter($lampiran, fn($f) => $f !== $file);
            $report->lampiran = array_values($lampiran);
            $report->save();

            // hapus fisik file
            \Storage::disk('public')->delete($file);

            return redirect()->back()->with('success', 'Lampiran berhasil dihapus.');
        }

        // === Field lain (default) ===
        if (!array_key_exists($field, $rules)) {
            return redirect()->back()->with('error', 'Field tidak valid.');
        }

        $request->validate([
            'value' => $rules[$field],
        ]);

        $report->$field = $value;
        $report->save();

        return redirect()->back()->with('success', 'Data berhasil diperbarui.');
    }

    // Update tindak lanjut
    public function updateFollowUp(Request $request, $id)
    {
        $request->validate([
            'deskripsi' => 'required|string',
            'lampiran' => 'nullable|file|max:2048',
        ]);

        $followUp = WbsFollowUp::findOrFail($id);

        $lampiran = $followUp->lampiran;
        if ($request->hasFile('lampiran')) {
            $lampiran = $request->file('lampiran')->store('wbs_followups', 'public');
        }

        $followUp->update([
            'deskripsi' => $request->deskripsi,
            'lampiran' => $lampiran,
        ]);

        return redirect()->back()->with('success', 'Tindak lanjut berhasil diperbarui.');
    }

    // Hapus tindak lanjut
    public function destroyFollowUp($id)
    {
        $followUp = WbsFollowUp::findOrFail($id);
        $report = $followUp->report; // relasi ke model Report/Aduan

        // Hapus tindak lanjut
        $followUp->delete();

        // Ubah status report jika bukan "Selesai"
        if ($report && $report->status !== 'Selesai') {
            // Kalau sebelumnya "Direspon", balikan jadi "Dibaca"
            if ($report->status === 'Direspon') {
                $report->status = 'Dibaca';
                $report->save();
            }
        }

        return redirect()->back()->with('success', 'Tindak lanjut berhasil dihapus, Status berubah menjadi Dibaca');
    }

    // Hapus laporan
    public function destroy($id)
    {
        $report = WbsReport::findOrFail($id);
        $report->delete();

        return redirect()->route('wbs_admin.kelola-aduan.index')
            ->with('success', 'Laporan berhasil dihapus.');
    }

    public function riwayat()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat aduan.');
        }

        $user = auth()->user();

        $aduan = Report::where('user_id', $user->id_user)
            ->latest()
            ->paginate(6, ['id', 'tracking_id', 'judul', 'status', 'created_at', 'file']);

        return view('wbs_admin.detail.riwayat', compact('aduan'));
    }

    public function riwayatWbs()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat WBS.');
        }

        $user = auth()->user();

        // Ambil semua kolom
        $aduan = WbsReport::where('user_id', $user->id_user)
            ->latest()
            ->paginate(6); // default ambil semua field

        return view('wbs_admin.detail.riwayatwbs', compact('aduan'));
    }
}
