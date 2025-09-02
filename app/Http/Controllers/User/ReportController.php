<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Models\Vote;
use App\Models\Report;
use App\Models\FollowUp;
use App\Models\WbsReport;
use App\Models\WbsComment;
use App\Models\FollowupRating;
use App\Models\Comment;
use App\Models\KategoriUmum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ReportController extends Controller
{
    /**
     * Menampilkan semua laporan milik user (atau semua jika tidak login).
     */
    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->role === 'admin') {
                $kategoriIds = $user->kategori->pluck('id')->toArray();

                $reports = Report::whereIn('kategori_id', $kategoriIds)
                    ->with('pelapor')
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'file', 'created_at']);
            } elseif ($user->role === 'superadmin') {
                $reports = Report::with('pelapor')
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'file', 'created_at']);
            } else {
                $reports = Report::where('user_id', $user->id_user)
                    ->with('pelapor')
                    ->latest()
                    ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'file', 'created_at']);
            }
        } else {
            $reports = Report::with('pelapor')
                ->latest()
                ->get(['id', 'judul', 'isi', 'nama_pengadu', 'kategori_id', 'status', 'file', 'created_at']);
        }

        // 🔹 Tambahkan statistik di sini
        $totalAduan = Report::count();

        $aduanBulanIni = Report::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        $aduanSelesai = Report::where('status', Report::STATUS_SELESAI)->count();

        return view('portal.welcome', compact('reports', 'totalAduan', 'aduanBulanIni', 'aduanSelesai'));
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
            'judul' => 'required|string|min:20|max:150',
            'isi' => 'required|string|min:120|max:1000',
            'kategori_id' => 'required|exists:kategori_umum,id',
            'wilayah_id' => 'required|exists:wilayah_umum,id',
            'file' => 'required|array|max:3',
            'file.*' => 'file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
            'lokasi' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'is_anonim' => 'nullable|boolean',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        // Simpan file
        if ($request->hasFile('file')) {
            $filePaths = [];
            foreach ($request->file('file') as $uploadedFile) {
                $filePaths[] = $uploadedFile->store('report_files', 'public');
            }
            $validated['file'] = $filePaths;
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

        // Ambil admin_id dari kategori_umum
        $kategori = KategoriUmum::find($validated['kategori_id']);
        if ($kategori && $kategori->admin_id) {
            $validated['admin_id'] = $kategori->admin_id;
        } else {
            return back()->with('error', 'Kategori belum memiliki admin yang ditugaskan.');
        }

        try {
            Report::create($validated);
            return redirect()->route('user.aduan.riwayat')->with('success', 'Laporan berhasil dikirim.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menyimpan laporan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail laporan lengkap dengan komentar & follow up.
     */
    public function show($id)
    {
        $report = Report::with([
            'kategori.admin',
            'wilayah',
            'user',
            'followUps.user',
            'followUps.ratings.user', // ⬅️ tambahin relasi rating+user
            'comments.user',
            'admin',
            'updatedBy',
            // ⬇️ tambahin ini supaya tiap followUp ada avg & count
            'followUps' => function ($q) {
                $q->withAvg('ratings', 'rating')
                    ->withCount('ratings');
            },
        ])->findOrFail($id);

        // 🔹 Validasi: Admin hanya bisa melihat laporan sesuai kategori
        if (auth()->check() && auth()->user()->role === 'admin') {
            if ($report->admin_id !== auth()->user()->id_user) {
                return response()->view('errors.akses-ditolak', [], 403);
            }
        }

        // 🔹 Tambah jumlah view
        $sessionKey = 'report_viewed_' . $id;
        if (!session()->has($sessionKey)) {
            $report->increment('views');
            session()->put($sessionKey, true);
        }

        // 🔹 Update status jika admin membuka aduan yang belum dibaca
        if (auth()->check() && auth()->user()->role === 'admin' && $report->status === Report::STATUS_DIAJUKAN) {
            $report->status = Report::STATUS_DIBACA;
            $report->save();
            session()->flash('success', 'Status laporan diperbarui menjadi Dibaca');
        }

        $followUps = $report->followUps->filter(function ($item) {
            return $item->user && in_array($item->user->role, ['admin', 'superadmin']);
        });

        $comments = $report->comments;

        // 🔹 --- HITUNG RATING ---
        $ratings = \App\Models\FollowupRating::whereIn('followup_id', $report->followUps->pluck('id'))->get();

        $totalReviews = $ratings->count();
        $averageRating = $totalReviews > 0 ? round($ratings->avg('rating'), 1) : 0;

        $ratingBreakdown = $ratings->groupBy('rating')->map->count();
        $ratingStats = [];
        for ($i = 5; $i >= 1; $i--) {
            $ratingStats[$i] = $ratingBreakdown->get($i, 0);
        }

        // 🔹 --- BUAT TIMELINE ---
        $timeline = [];

        // Aduan dibuat
        $timeline[] = [
            'time' => $report->created_at,
            'type' => 'created',
            'title' => 'Aduan dengan Nomor ' . $report->tracking_id . ' dibuat oleh '
                . ($report->is_anonim ? 'Anonim' : $report->nama_pengadu),
        ];

        // Disposisikan ke admin kategori (jika ada)
        if ($report->kategori && $report->kategori->admin) {
            $timeline[] = [
                'time' => $report->created_at,
                'type' => 'assigned',
                'title' => 'Aduan didisposisikan otomatis oleh sistem ke Admin ' . optional($report->kategori->admin)->name,
            ];
        }

        // Disposisi diubah (hanya jika sudah ada admin_id sebelumnya dan kemudian diganti)
        if ($report->wasChanged('admin_id') && $report->getOriginal('admin_id') !== null) {
            $timeline[] = [
                'time' => $report->updated_at,
                'type' => 'reassigned',
                'title' => 'Aduan didisposisikan ulang ke Admin ' . (optional($report->admin)->name ?? '-')
                    . ' oleh ' . (optional($report->updatedBy)->name ?? 'System'),
            ];
        }

        // Waktu admin pertama bertindak
        $firstAdminActionTime = optional(
            $report->followUps
                ->filter(fn($fu) => in_array($fu->user->role ?? '', ['admin', 'superadmin']))
                ->sortBy('created_at')
                ->first()
        )->created_at;

        // Dibaca admin
        if ($report->status !== Report::STATUS_DIAJUKAN) {
            $timeline[] = [
                'time' => $firstAdminActionTime ?? $report->updated_at,
                'type' => 'read',
                'title' => 'Admin ' . (optional($report->admin)->name ?? '-') . ' telah membaca aduan',
            ];
        }

        // Follow up
        foreach ($followUps as $fu) {
            $timeline[] = [
                'time' => $fu->created_at,
                'type' => 'followup',
                'title' => 'Tindak Lanjut oleh ' . (optional($fu->user)->name ?? 'Admin'),
            ];
        }

        // Komentar
        foreach ($comments as $c) {
            $timeline[] = [
                'time' => $c->created_at,
                'type' => 'comment',
                'title' => 'Komentar dari ' . (optional($c->user)->name ?? 'Anonim'),
            ];
        }

        // Status selesai
        if ($report->status === Report::STATUS_SELESAI) {
            $timeline[] = [
                'time' => $report->updated_at,
                'type' => 'done',
                'title' => 'Aduan telah dinyatakan Selesai oleh ' . (optional($report->admin)->name ?? 'Admin'),
            ];
        }

        // Urutkan dari terbaru
        $timeline = collect($timeline)->sortByDesc('time')->values()->all();

        return view('portal.daftar-aduan.detail.index', compact(
            'report',
            'followUps',
            'comments',
            'timeline',
            'averageRating',
            'totalReviews',
            'ratingStats',
            'ratings'
        ));
    }

    public function trackByTrackingId(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
        ]);

        $trackingId = $request->tracking_id;

        $aduan = WbsReport::where('tracking_id', $trackingId)->first();

        if (!$aduan) {
            return redirect()
                ->route('wbs.index', ['tab' => 'riwayat'])
                ->with('error', 'Kode unik tidak ditemukan.')
                ->withInput();
        }

        // Redirect ke halaman detail WBS sesuai id
        return redirect()->route('user.aduan.riwayatwbs.show', ['id' => $aduan->id]);
    }

    public function showWbs($id)
    {
        $aduan = WbsReport::with(['kategori', 'wilayah'])->findOrFail($id);

        return view('portal.daftar-aduan.detail.riwayatwbs', compact('aduan'));
    }

    public function like($id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberikan like.');
        }

        $report = Report::findOrFail($id);
        $vote = Vote::where('user_id', $user->id_user)->where('report_id', $report->id)->first();

        if ($vote && $vote->vote_type === 'like') {
            // batalin like
            $vote->delete();
            $report->decrement('likes');
        } elseif ($vote && $vote->vote_type === 'dislike') {
            // ubah dislike jadi like
            $vote->update(['vote_type' => 'like']);
            $report->increment('likes');
            if ($report->dislikes > 0) {
                $report->decrement('dislikes');
            }
        } else {
            // baru pertama kali like
            Vote::create([
                'user_id' => $user->id_user,
                'report_id' => $report->id,
                'vote_type' => 'like',
            ]);
            $report->increment('likes');
        }

        return back();
    }

    public function dislike($id)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberikan dislike.');
        }

        $report = Report::findOrFail($id);
        $vote = Vote::where('user_id', $user->id_user)->where('report_id', $report->id)->first();

        if ($vote && $vote->vote_type === 'dislike') {
            // batalin dislike
            $vote->delete();
            if ($report->dislikes > 0) {
                $report->decrement('dislikes');
            }
        } elseif ($vote && $vote->vote_type === 'like') {
            // ubah like jadi dislike
            $vote->update(['vote_type' => 'dislike']);
            if ($report->likes > 0) {
                $report->decrement('likes');
            }
            $report->increment('dislikes');
        } else {
            // baru pertama kali dislike
            Vote::create([
                'user_id' => $user->id_user,
                'report_id' => $report->id,
                'vote_type' => 'dislike',
            ]);
            $report->increment('dislikes');
        }

        return back();
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

        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Hanya admin atau superadmin yang dapat memberikan tindak lanjut.');
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

        // Update status laporan menjadi 'Direspon' hanya jika status sebelumnya 'Dibaca'
        $report = Report::findOrFail($reportId);

        if (in_array($report->status, [Report::STATUS_DIAJUKAN, Report::STATUS_DIBACA])) {
            $report->status = Report::STATUS_DIRESPON;
            $report->save();
        }

        return back()->with('success', 'Tindak lanjut berhasil dikirim' .
            ($report->status === Report::STATUS_DIRESPON ? ', Status Aduan menjadi Direspon' : ''));
    }

    public function storeFollowupRating(Request $request, $followupId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk memberi rating.');
        }

        // Cek kalau user sudah pernah kasih rating → update
        $rating = FollowupRating::updateOrCreate(
            [
                'followup_id' => $followupId,
                'user_id' => $user->id_user,
            ],
            [
                'rating' => $request->rating,
                'komentar' => $request->komentar,
            ]
        );

        return back()->with('success', 'Rating berhasil dikirim.');
    }

    public function updateFollowupRating(Request $request, $followupId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk mengubah rating.');
        }

        $rating = FollowupRating::where('followup_id', $followupId)
            ->where('user_id', $user->id_user)
            ->first();

        if (!$rating) {
            return back()->with('error', 'Rating tidak ditemukan.');
        }

        $rating->update([
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Rating berhasil diperbarui.');
    }

    public function deleteFollowupRating($followupId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login untuk menghapus rating.');
        }

        $rating = FollowupRating::where('followup_id', $followupId)
            ->where('user_id', $user->id_user)
            ->first();

        if (!$rating) {
            return back()->with('error', 'Rating tidak ditemukan.');
        }

        $rating->delete();

        return back()->with('success', 'Rating berhasil dihapus.');
    }

    public function storeWbsComment(Request $request, $wbsId)
    {
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        $comment = new WbsComment([
            'report_id' => $wbsId,  // <- sesuaikan dengan nama kolom di DB
            'user_id' => Auth::user()->id_user,
            'pesan' => $request->pesan,
        ]);

        if ($request->hasFile('file')) {
            $comment->file = $request->file('file')->store('wbs_comment_files', 'public');
        }

        $comment->save();

        return back()->with('success', 'Komentar WBS berhasil dikirim.');
    }

    public function updateWbsComment(Request $request, WbsComment $comment)
    {
        // Validasi hak akses: hanya pemilik komentar atau admin/superadmin
        if ($comment->user_id !== Auth::user()->id_user && !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah komentar ini.');
        }

        // Validasi input
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        // Update pesan
        $comment->pesan = $request->pesan;

        // Jika ada file baru, simpan
        if ($request->hasFile('file')) {
            $comment->file = $request->file('file')->store('wbs_comment_files', 'public');
        }

        $comment->save();

        return back()->with('success', 'Komentar berhasil diperbarui.');
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

        if (!in_array(Auth::user()->role, ['user', 'admin', 'superadmin'])) {
            abort(403, 'Hanya user, admin, dan superadmin yang dapat mengirim komentar.');
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

    public function updateComment(Request $request, Comment $comment)
    {
        // Validasi hak akses: hanya pemilik komentar atau admin/superadmin
        if ($comment->user_id !== Auth::user()->id_user && !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah komentar ini.');
        }

        // Validasi input
        $request->validate([
            'pesan' => 'required|string',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,zip|max:10240',
        ]);

        // Update pesan
        $comment->pesan = $request->pesan;

        // Jika ada file baru, simpan dan hapus file lama jika ada
        if ($request->hasFile('file')) {
            if ($comment->file && \Storage::disk('public')->exists($comment->file)) {
                \Storage::disk('public')->delete($comment->file);
            }
            $comment->file = $request->file('file')->store('comment_files', 'public');
        }

        $comment->save();

        return back()->with('success', 'Komentar berhasil diperbarui.');
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

    public function deleteWbsComment($id)
    {
        $comment = WbsComment::findOrFail($id);

        // Cek apakah user adalah pemilik komentar, admin, atau superadmin
        if (Auth::id() !== $comment->user_id && !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak diizinkan menghapus komentar WBS ini.');
        }

        // Hapus file jika ada
        if ($comment->file && \Storage::disk('public')->exists($comment->file)) {
            \Storage::disk('public')->delete($comment->file);
        }

        $comment->delete();

        return back()->with('success', 'Komentar WBS berhasil dihapus.');
    }
    /**
     * Hapus komentar.
     */
    public function deleteComment($id)
    {
        $comment = Comment::findOrFail($id);

        // Cek apakah user adalah pemilik komentar, admin, atau superadmin
        if (Auth::id() !== $comment->user_id && !in_array(Auth::user()->role, ['admin', 'superadmin'])) {
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

        // Cek apakah user adalah admin atau superadmin
        if (!in_array(Auth::user()->role, ['admin', 'superadmin'])) {
            abort(403, 'Anda tidak diizinkan menghapus tindak lanjut ini.');
        }

        $userRole = Auth::user()->role;

        // Hapus file jika ada
        if ($followUp->file && \Storage::disk('public')->exists($followUp->file)) {
            \Storage::disk('public')->delete($followUp->file);
        }

        // Hapus tindak lanjut
        $followUp->delete();

        // Ambil ulang report dan cek tindak lanjut tersisa
        $report = Report::findOrFail($reportId);
        $hasFollowUps = $report->followUps()->exists();

        // Jika tidak ada tindak lanjut lagi dan statusnya DIRESPON, atur ulang status sesuai role
        if (!$hasFollowUps && $report->status === Report::STATUS_DIRESPON) {
            // Cek apakah status selesai (misal kamu punya constant STATUS_SELESAI)
            $statusSelesai = Report::STATUS_SELESAI; // contoh

            if ($report->status !== $statusSelesai) {
                if ($userRole === 'superadmin') {
                    $report->status = Report::STATUS_DIAJUKAN; // ubah ke diajukan jika dihapus oleh superadmin
                } else {
                    $report->status = Report::STATUS_DIBACA; // kalau admin tetap ke dibaca
                }
                $report->save();

                $pesanStatus = $userRole === 'superadmin' ? 'Status Aduan menjadi Diajukan' : 'Status Aduan menjadi Dibaca';

                return back()->with('success', 'Tindak lanjut berhasil dihapus, ' . $pesanStatus);
            }
        }

        return back()->with('success', 'Tindak lanjut berhasil dihapus');
    }

    public function lacak(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string',
        ]);

        $report = Report::where('tracking_id', $request->tracking_id)->first();

        if (!$report) {
            return redirect()->back()->with('error', 'Nomor Tiket Aduan tidak ditemukan.');
        }

        // Redirect ke halaman detail
        return redirect()->route('reports.show', ['id' => $report->id]);
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

        return view('portal.daftar-aduan.riwayat', compact('aduan'));
    }

    public function riwayatWbs()
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan login untuk melihat riwayat WBS.');
        }

        $user = auth()->user();

        // Ambil semua kolom
        $aduan = \App\Models\WbsReport::where('user_id', $user->id_user)
            ->latest()
            ->paginate(6); // default ambil semua field

        return view('portal.daftar-aduan.riwayatwbs', compact('aduan'));
    }
}
