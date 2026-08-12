<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\HasilLaporan;

class FeedController extends Controller
{
    public function index()
    {
        $feeds = HasilLaporan::where('status_publish', 'publish')
            ->with(['laporan.kategori', 'lampiranHasil'])
            ->latest('tanggal_publish')
            ->paginate(10);

        return view('user.feed.feed_laporan', compact('feeds'));
    }

    public function show($id)
    {
        $feed = HasilLaporan::where('status_publish', 'publish')
            ->with(['laporan.kategori', 'lampiranHasil', 'admin'])
            ->findOrFail($id);

        return view('user.feed.detail_feed', compact('feed'));
    }
}
