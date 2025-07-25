<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\FollowUp;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    /**
     * Menampilkan semua laporan milik user (atau semua jika tidak login).
     */
    public function index()
    {
        if (auth()->check()) {
            $reports = Report::where('user_id', auth()->user()->id_user)
                ->latest()
                ->get(['id_report', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'created_at']);
        } else {
            $reports = Report::latest()
                ->get(['id_report', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'created_at']);
        }

        return view('portal.welcome', compact('reports'));
    }

    /**
     * Tampilkan form pembuatan laporan.
     */
    public function create()
    {
        return view('user.aduan.create');
    }

    /**
     * Simpan laporan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|min:30|max:255',
            'isi' => 'required|string|min:120',
            'kategori_id' => 'required|exists:kategori_umum,id',
            'wilayah_id' => 'required|exists:wilayah_umum,id',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
            'lokasi' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_anonim' => 'nullable|boolean',
        ]);

        // File handling
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('report_files', 'public');
        }

        $validated['is_anonim'] = $request->boolean('is_anonim');
        $validated['status'] = Report::STATUS_DIAJUKAN;

        if (!$validated['is_anonim']) {
            $user = auth()->user();
            if (!$user)
                return back()->with('error', 'Pengguna tidak terautentikasi.');

            $validated['user_id'] = $user->id_user;
            $validated['nama_pengadu'] = $user->name;
            $validated['email_pengadu'] = $user->email;
            $validated['telepon_pengadu'] = $user->nomor_telepon ?? null;
            $validated['nik'] = $user->nik ?? null;
        } else {
            $validated['user_id'] = null;
            $validated['nama_pengadu'] = 'Anonim';
            $validated['email_pengadu'] = 'anonim@domain.com';
            $validated['telepon_pengadu'] = null;
            $validated['nik'] = null;
        }

        try {
            Report::create($validated);
            return redirect()->route('beranda')->with('success', 'Laporan berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail laporan lengkap dengan komentar & follow up.
     */
    public function show($id)
    {
        // Cari laporan beserta relasi kategori, wilayah, user, followUps, dan comments
        $report = Report::with([
            'kategori',
            'wilayah',
            'user',
            'followUps.user',
            'comments.user'
        ])->findOrFail($id);

        // Pastikan hanya admin yang bisa mengubah status laporan menjadi 'Dibaca' dan statusnya masih 'Diajukan'
        if (auth()->check() && auth()->user()->role === 'admin' && $report->status === Report::STATUS_DIAJUKAN) {
            // Ubah status laporan menjadi 'Dibaca'
            $report->status = Report::STATUS_DIBACA;
            $report->save(); // Simpan perubahan status

            // Set pesan sukses
            session()->flash('success', 'Status laporan berhasil diperbarui menjadi Dibaca');
        }

        // Filter followUps untuk hanya menampilkan yang dibuat oleh user dengan role 'admin'
        $followUps = $report->followUps->filter(
            fn($item) => $item->user && $item->user->role === 'admin'
        );

        // Ambil semua komentar terkait laporan
        $comments = $report->comments;

        // Tampilkan view dengan data yang telah diolah
        return view('portal.daftar-aduan.detail.index', compact('report', 'followUps', 'comments'));
    }

    /**
     * Simpan tindak lanjut dari admin.
     */
    public function storeFollowUp(Request $request, $reportId)
    {
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Hanya admin yang dapat memberikan tindak lanjut.');
        }

        $followUp = new FollowUp([
            'report_id' => $reportId,
            'user_id' => Auth::user()->id_user,
            'pesan' => $request->pesan,
        ]);

        if ($request->hasFile('file')) {
            $followUp->file = $request->file('file')->store('followup_files', 'public');
        }

        $followUp->save();

        // Update status laporan menjadi 'Direspon' jika ada tindak lanjut
        $report = Report::findOrFail($reportId);
        $report->status = Report::STATUS_DIRESPON;
        $report->save();

        return back()->with('success', 'Tindak lanjut berhasil dikirim, Status Aduan menjadi Direspon');
    }

    /**
     * Simpan komentar dari user.
     */
    public function storeComment(Request $request, $reportId)
    {
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        if (Auth::user()->role !== 'user' && Auth::user()->role !== 'admin') {
            abort(403, 'Hanya user dan admin yang dapat mengirim komentar.');
        }

        $comment = new Comment([
            'report_id' => $reportId,
            'user_id' => Auth::user()->id_user,
            'pesan' => $request->pesan,
        ]);

        if ($request->hasFile('file')) {
            $comment->file = $request->file('file')->store('comment_files', 'public');
        }

        $comment->save();

        return back()->with('success', 'Komentar berhasil dikirim.');
    }

    public function getBadgeCounts($id)
    {
        $report = Report::withCount(['followUps', 'comments'])->findOrFail($id);

        return response()->json([
            'followUps' => $report->follow_ups_count,
            'comments' => $report->comments_count,
            'lampiran' => $report->file ? 1 : 0,
        ]);
    }

    /**
     * Hapus komentar.
     */
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        // Cek apakah user adalah pemilik komentar atau admin
        if (Auth::id() !== $comment->user_id && Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak diizinkan menghapus komentar ini.');
        }

        // Hapus file jika ada
        if ($comment->file && \Storage::disk('public')->exists($comment->file)) {
            \Storage::disk('public')->delete($comment->file);
        }

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }

    /**
     * Hapus tindak lanjut (hanya admin yang bisa).
     */
    public function deleteFollowUp($reportId, $followUpId)
    {
        $followUp = FollowUp::findOrFail($followUpId);

        // Cek apakah user adalah admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Anda tidak diizinkan menghapus tindak lanjut ini.');
        }

        // Hapus file jika ada
        if ($followUp->file && \Storage::disk('public')->exists($followUp->file)) {
            \Storage::disk('public')->delete($followUp->file);
        }

        // Hapus tindak lanjut
        $followUp->delete();

        // Jika tidak ada tindak lanjut lagi, ubah status laporan menjadi 'Dibaca'
        $report = Report::findOrFail($reportId);
        if ($report->followUps->isEmpty()) {
            $report->status = Report::STATUS_DIBACA;
            $report->save();
        }

        return back()->with('success', 'Tindak lanjut berhasil dihapus, Status Aduan menjadi Dibaca');
    }
}
