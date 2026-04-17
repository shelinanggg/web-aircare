<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'    => Item::count(),
            'found'    => Item::where('status', 'found')->count(),
            'claimed'  => Item::where('status', 'claimed')->count(),
            'disposed' => Item::where('status', 'disposed')->count(),
        ];

        $byCampus = [
            'kampus-a' => Item::where('campus', 'kampus-a')->where('status', 'found')->count(),
            'kampus-b' => Item::where('campus', 'kampus-b')->where('status', 'found')->count(),
            'kampus-c' => Item::where('campus', 'kampus-c')->where('status', 'found')->count(),
        ];

        $byCategory = Item::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $recentItems = Item::orderByDesc('created_at')->take(5)->get();
        $recentLogs  = ActivityLog::with(['user', 'item'])->orderByDesc('created_at')->take(8)->get();

        return view('dashboard.index', compact('stats', 'byCampus', 'byCategory', 'recentItems', 'recentLogs'));
    }
}
