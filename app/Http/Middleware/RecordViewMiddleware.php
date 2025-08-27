<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\PageView;

class RecordViewMiddleware
{
    public function handle($request, Closure $next)
    {
        if ($request->route()) {
            // ID unik per halaman
            $viewableId = substr(md5($request->path()), 0, 15);

            // ID visitor lebih akurat (IP + User Agent)
            $visitorId = sha1($request->ip() . '|' . $request->userAgent());

            // Cek apakah visitor ini sudah akses halaman ini dalam 1 menit terakhir
            $alreadyViewed = PageView::where('viewable_id', $viewableId)
                ->where('visitor', $visitorId)
                ->where('viewed_at', '>=', now()->subMinute())
                ->exists();

            if (!$alreadyViewed) {
                PageView::create([
                    'viewable_type' => 'page',
                    'viewable_id'   => $viewableId,
                    'visitor'       => $visitorId,
                    'ip_address'    => $request->ip(),
                    'user_agent'    => $request->userAgent(),
                    'collection'    => $request->path(),
                    'viewed_at'     => now(),
                ]);
            }
        }

        return $next($request);
    }
}
