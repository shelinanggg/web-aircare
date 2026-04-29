<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('campus')) {
            $query->where('campus', $request->campus);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan tanggal ditemukan
        if ($request->filled('date')) {
            $query->whereDate('found_date', $request->date);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('qr_code', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('items.index', compact('items'));
    }

    public function create()
    {
        return view('items.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'category'        => 'required|in:valuable,documents,electronics,personal,other',
            'campus'          => 'required|in:kampus-a,kampus-b,kampus-c',
            'location_detail' => 'nullable|string|max:255',
            'found_by'        => 'nullable|string|max:255',
            'found_date'      => 'required|date',
            'notes'           => 'nullable|string',
            'image'           => 'nullable|image|max:2048',
        ]);

        $validated['qr_code'] = Item::generateQrCode();
        $validated['status'] = 'found';

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item = Item::create($validated);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'item_id'     => $item->id,
            'action'      => 'item_found',
            'description' => 'Barang baru tercatat: ' . $item->name . ' di ' . $item->campus_label,
        ]);

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Barang berhasil dicatat dengan kode ' . $item->qr_code);
    }

    public function show(Item $item)
    {
        $logs = ActivityLog::where('item_id', $item->id)
            ->with('user')
            ->orderByDesc('created_at')
            ->get();

        return view('items.show', compact('item', 'logs'));
    }

    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'category'        => 'required|in:valuable,documents,electronics,personal,other',
            'campus'          => 'required|in:kampus-a,kampus-b,kampus-c',
            'location_detail' => 'nullable|string|max:255',
            'found_by'        => 'nullable|string|max:255',
            'found_date'      => 'required|date',
            'notes'           => 'nullable|string',
            'image'           => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }

            $validated['image'] = $request->file('image')->store('items', 'public');
        }

        $item->update($validated);

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'item_id'     => $item->id,
            'action'      => 'item_updated',
            'description' => 'Data barang diperbarui: ' . $item->name,
        ]);

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Data barang diperbarui.');
    }

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
            'description' => 'Barang diambil oleh ' . $request->claimed_by . ' (NIM: ' . $request->claimer_nim . ')',
        ]);

        return redirect()
            ->route('items.show', $item)
            ->with('success', 'Barang berhasil diserahkan.');
    }

    public function dispose(Request $request, Item $item)
    {
        // Perbaikan: Mengambil input 'status' (sesuai nama form HTML), bukan 'type'
        $type = $request->input('status', 'disposed');

        if (!in_array($type, ['disposed', 'donated', 'handed_over'])) {
            $type = 'disposed';
        }

        $item->update([
            'status' => $type,
        ]);

        $label = match ($type) {
            'disposed'    => 'Dimusnahkan',
            'donated'     => 'Dihibahkan',
            'handed_over' => 'Diserahkan ke DITPILAR',
            default       => 'Diproses',
        };

        ActivityLog::create([
            'user_id'     => auth()->id(),
            'item_id'     => $item->id,
            'action'      => 'item_status_changed',
            'description' => 'Status barang: ' . $label . ' - ' . $item->name,
        ]);

        return redirect()
            ->route('items.index')
            ->with('success', 'Status barang berhasil diperbarui.');
    }

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

    public function publicSearch(Request $request)
    {
        $query = Item::where('status', 'found');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('category', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%')
                    ->orWhere('qr_code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('campus')) {
            $query->where('campus', $request->campus);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter berdasarkan tanggal ditemukan untuk halaman Public
        if ($request->filled('date')) {
            $query->whereDate('found_date', $request->date);
        }

        $items = $query->orderByDesc('found_date')
            ->paginate(9)
            ->withQueryString();

        return view('items.public', compact('items'));
    }

    public function scan($code)
    {
        $item = Item::where('qr_code', $code)->firstOrFail();

        return redirect()->route('items.show', $item);
    }
}