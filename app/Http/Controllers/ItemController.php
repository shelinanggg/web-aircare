<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = Item::with('category');

        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER CAMPUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('campus')) {

            $query->where('campus', $request->campus);

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER CATEGORY
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->whereHas('category', function ($q) use ($request) {

                $q->where('slug', $request->category);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | FILTER DATE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            $query->whereDate('found_date', $request->date);

        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('qr_code', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');

            });

        }

        $items = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('items.index', compact('items'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('items.create', compact('categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([

            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',

            'category_id'     => 'required|exists:categories,id',

            'campus'          => 'required|in:kampus-a,kampus-b,kampus-c',

            'location_detail' => 'nullable|string|max:255',

            'found_by'        => 'nullable|string|max:255',

            'found_date'      => 'required|date',

            'notes'           => 'nullable|string',

            'image'           => 'nullable|image|max:2048',

        ]);

        /*
        |--------------------------------------------------------------------------
        | GENERATE QR
        |--------------------------------------------------------------------------
        */

        $validated['qr_code'] = Item::generateQrCode();

        $validated['status'] = 'found';

        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $validated['image'] = $request
                ->file('image')
                ->store('items', 'public');

        }

        /*
        |--------------------------------------------------------------------------
        | CREATE ITEM
        |--------------------------------------------------------------------------
        */

        $item = Item::create($validated);

        /*
        |--------------------------------------------------------------------------
        | LOG
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([

            'user_id'     => auth()->id(),

            'item_id'     => $item->id,

            'action'      => 'item_found',

            'description' => 'Barang baru tercatat: ' .
                             $item->name .
                             ' di ' .
                             $item->campus_label,

        ]);

        return redirect()
            ->route('items.show', $item)
            ->with(
                'success',
                'Barang berhasil dicatat dengan kode ' . $item->qr_code
            );
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(Item $item)
    {
        $item->load('category');

        $logs = ActivityLog::where('item_id', $item->id)
            ->with('user')
            ->latest()
            ->get();

        return view('items.show', compact('item', 'logs'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(Item $item)
    {
        $item->load('category');

        $categories = Category::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('items.edit', compact('item', 'categories'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([

            'name'            => 'required|string|max:255',

            'description'     => 'nullable|string',

            'category_id'     => 'required|exists:categories,id',

            'campus'          => 'required|in:kampus-a,kampus-b,kampus-c',

            'location_detail' => 'nullable|string|max:255',

            'found_by'        => 'nullable|string|max:255',

            'found_date'      => 'required|date',

            'notes'           => 'nullable|string',

            'image'           => 'nullable|image|max:2048',

        ]);

        /*
        |--------------------------------------------------------------------------
        | IMAGE
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            if ($item->image) {

                Storage::disk('public')->delete($item->image);

            }

            $validated['image'] = $request
                ->file('image')
                ->store('items', 'public');

        }

        /*
        |--------------------------------------------------------------------------
        | UPDATE ITEM
        |--------------------------------------------------------------------------
        */

        $item->update($validated);

        /*
        |--------------------------------------------------------------------------
        | LOG
        |--------------------------------------------------------------------------
        */

        ActivityLog::create([

            'user_id'     => auth()->id(),

            'item_id'     => $item->id,

            'action'      => 'item_updated',

            'description' => 'Data barang diperbarui: ' .
                             $item->name,

        ]);

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Data barang diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | CLAIM
    |--------------------------------------------------------------------------
    */

    public function claim(Request $request, Item $item)
    {
        $request->validate([

            'claimed_by'  => 'required|string|max:255',

            'claimer_nim' => 'nullable|string|max:50',

        ]);

        $item->update([

            'status'       => 'claimed',

            'claimed_by'   => $request->claimed_by,

            'claimer_nim'  => $request->claimer_nim,

            'claimed_date' => today(),

        ]);

        ActivityLog::create([

            'user_id'     => auth()->id(),

            'item_id'     => $item->id,

            'action'      => 'item_claimed',

            'description' => 'Barang diambil oleh ' .
                             $request->claimed_by .
                             ' (NIM: ' .
                             $request->claimer_nim .
                             ')',

        ]);

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Barang berhasil diserahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | DISPOSE
    |--------------------------------------------------------------------------
    */

    public function dispose(Request $request, Item $item)
    {
        $type = $request->input('status', 'disposed');

        if (!in_array($type, [

            'disposed',
            'donated',
            'handed_over',

        ])) {

            $type = 'disposed';

        }

        $item->update([

            'status' => $type,

        ]);

        $label = match ($type) {

            'disposed'     => 'Dimusnahkan',

            'donated'      => 'Dihibahkan',

            'handed_over'  => 'Diserahkan ke DITPILAR',

            default        => 'Diproses',

        };

        ActivityLog::create([

            'user_id'     => auth()->id(),

            'item_id'     => $item->id,

            'action'      => 'item_status_changed',

            'description' => 'Status barang: ' .
                             $label .
                             ' - ' .
                             $item->name,

        ]);

        return redirect()
            ->route('items.index')
            ->with('success', 'Status barang berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(Item $item)
    {
        if ($item->image) {

            Storage::disk('public')->delete($item->image);

        }

        $item->delete();

        return redirect()
            ->route('items.index')
            ->with('success', 'Barang dihapus dari sistem.');
    }

    /*
    |--------------------------------------------------------------------------
    | PUBLIC SEARCH
    |--------------------------------------------------------------------------
    */

    public function publicSearch(Request $request)
    {
        $query = Item::with('category')
            ->where('status', 'found');

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('qr_code', 'like', '%' . $request->search . '%');

            });

        }

        /*
        |--------------------------------------------------------------------------
        | CAMPUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('campus')) {

            $query->where('campus', $request->campus);

        }

        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        if ($request->filled('category')) {

            $query->whereHas('category', function ($q) use ($request) {

                $q->where('slug', $request->category);

            });

        }

        /*
        |--------------------------------------------------------------------------
        | DATE
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            $query->whereDate('found_date', $request->date);

        }

        $items = $query
            ->latest('found_date')
            ->paginate(9)
            ->withQueryString();

        return view('items.public', compact('items'));
    }

    /*
    |--------------------------------------------------------------------------
    | SCAN QR
    |--------------------------------------------------------------------------
    */

    public function scan($code)
    {
        $item = Item::where('qr_code', $code)
            ->firstOrFail();

        return redirect()
            ->route('items.show', $item);
    }
}