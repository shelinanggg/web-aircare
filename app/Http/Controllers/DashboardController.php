<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | STATISTIK UTAMA
        |--------------------------------------------------------------------------
        */

        $stats = [
            'total'    => Item::count(),

            'found'    => Item::where('status', 'found')->count(),

            'claimed'  => Item::where('status', 'claimed')->count(),

            'disposed' => Item::where('status', 'disposed')->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | STATISTIK KAMPUS
        |--------------------------------------------------------------------------
        */

        $byCampus = [

            'kampus-a' => Item::where('campus', 'kampus-a')
                ->where('status', 'found')
                ->count(),

            'kampus-b' => Item::where('campus', 'kampus-b')
                ->where('status', 'found')
                ->count(),

            'kampus-c' => Item::where('campus', 'kampus-c')
                ->where('status', 'found')
                ->count(),
        ];

        /*
        |--------------------------------------------------------------------------
        | STATISTIK KATEGORI
        |--------------------------------------------------------------------------
        |
        | SEKARANG SUDAH PAKAI RELASI category_id
        | BUKAN category STRING LAGI
        |
        */

        $byCategory = Category::withCount('items')
            ->get()
            ->pluck('items_count', 'name')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | DATA TERBARU
        |--------------------------------------------------------------------------
        */

        $recentItems = Item::with('category')
            ->latest()
            ->take(5)
            ->get();

        $recentLogs = ActivityLog::with(['user', 'item'])
            ->latest()
            ->take(8)
            ->get();

        return view('dashboard.index', compact(
            'stats',
            'byCampus',
            'byCategory',
            'recentItems',
            'recentLogs'
        ));
    }
}