<?php

namespace App\Http\Controllers\WbsAdmin;

use App\Http\Controllers\Controller;
use App\Models\WbsReport;
use App\Models\Report;
use App\Models\WbsFollowUp;
use App\Models\WbsComment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class WbsAduanController extends Controller
{
    // Menampilkan semua laporan
    public function index(Request $request)
    {
        $wbsAdmin = Auth::user();

        $query = WbsReport::with(['kategori', 'wilayah', 'pelapor']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->orderByDesc('created_at')->paginate(10)->appends($request->query());

        // pastikan lampiran jadi array
        $reports->getCollection()->transform(function ($report) {
            if (is_string($report->lampiran)) {
                $report->lampiran = json_decode($report->lampiran, true);
            }
            return $report;
        });

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

        // decode jika masih string
        if (is_string($report->lampiran)) {
            $report->lampiran = json_decode($report->lampiran, true);
        }

        if ($report->status === 'Diajukan') {
            $report->status = 'Dibaca';
            $report->save();
            session()->flash('success', 'Status laporan otomatis berubah menjadi Dibaca.');
        }

        return view('wbs_admin.detail.index', compact('report'));
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
            $destinationPath = public_path('wbs_comments');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move($destinationPath, $fileName);

            // simpan path relatif agar bisa dipanggil dengan asset()
            $file = 'wbs_comments/' . $fileName;
        }

        WbsComment::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(),
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

        $file = $comment->file; // ambil file lama

        if ($request->hasFile('file')) {
            // hapus file lama kalau ada
            if ($file && file_exists(public_path($file))) {
                unlink(public_path($file));
            }

            // pastikan folder ada
            $destinationPath = public_path('wbs_comments');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            // generate nama file baru
            $fileName = time() . '_' . uniqid() . '_' . $request->file('file')->getClientOriginalName();

            // pindahkan file
            $request->file('file')->move($destinationPath, $fileName);

            // simpan path relatif ke public
            $file = 'wbs_comments/' . $fileName;
        }

        // update data comment
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

        if ($comment->file && file_exists(public_path($comment->file))) {
            unlink(public_path($comment->file));
        }

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

            return back()->with('success', 'Lokasi & Uraian berhasil diperbarui.');
        }

        // Update lampiran
        if ($field === 'lampiran') {
            $request->validate([
                'lampiran.*' => 'file|max:2048|mimes:jpg,jpeg,png,gif,pdf,doc,docx',
            ]);

            if ($request->hasFile('lampiran')) {
                $newFiles = [];
                foreach ($request->file('lampiran') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->move(public_path('lampiran'), $fileName);
                    $newFiles[] = 'lampiran/' . $fileName;
                }

                $oldFiles = is_string($report->lampiran)
                    ? json_decode($report->lampiran, true)
                    : ($report->lampiran ?? []);

                $report->lampiran = array_merge($oldFiles, $newFiles);
                $report->save();
            }

            return back()->with('success', 'Lampiran berhasil diperbarui.');
        }

        // === Hapus lampiran tertentu ===
        if ($field === 'hapus_lampiran') {
            $file = $request->input('file');
            $lampiran = $report->lampiran ?? [];

            // hapus dari array
            $lampiran = array_filter($lampiran, fn($f) => $f !== $file);
            $report->lampiran = array_values($lampiran);
            $report->save();

            // hapus file fisik langsung di public
            $filePath = public_path($file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            return back()->with('success', 'Lampiran berhasil dihapus.');
        }

        // === Field lain (default) ===
        if (!array_key_exists($field, $rules)) {
            return back()->with('error', 'Field tidak valid.');
        }

        $request->validate([
            'value' => $rules[$field],
        ]);

        $report->$field = $value;
        $report->save();

        return back()->with('success', 'Data berhasil diperbarui.');
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
            $destinationPath = public_path('wbs_followups');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $fileName = time() . '_' . $request->file('lampiran')->getClientOriginalName();
            $request->file('lampiran')->move($destinationPath, $fileName);

            $lampiran = 'wbs_followups/' . $fileName; // simpan path relatif
        }

        // Simpan follow-up
        WbsFollowUp::create([
            'report_id' => $report->id,
            'user_id' => Auth::id(), // admin yg follow up
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
            // Hapus file lama kalau ada
            if ($lampiran && file_exists(public_path($lampiran))) {
                unlink(public_path($lampiran));
            }

            $destinationPath = public_path('wbs_followups');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $fileName = time() . '_' . $request->file('lampiran')->getClientOriginalName();
            $request->file('lampiran')->move($destinationPath, $fileName);

            $lampiran = 'wbs_followups/' . $fileName;
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
        $report = $followUp->report;

        // Hapus file lampiran kalau ada
        if ($followUp->lampiran && file_exists(public_path($followUp->lampiran))) {
            unlink(public_path($followUp->lampiran));
        }

        // Hapus tindak lanjut
        $followUp->delete();

        // Update status report kalau bukan "Selesai"
        if ($report && $report->status !== 'Selesai') {
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
