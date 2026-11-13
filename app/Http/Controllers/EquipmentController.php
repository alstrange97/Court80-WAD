<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Rental;
use App\Models\Sport;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

class EquipmentController extends Controller
{
    // ==========================================
    // 1. HALAMAN KATALOG
    // ==========================================
    public function index(Request $request)
    {
        try {
            $filter_sport = $request->input('sport', 'all');
            $filter_category = $request->input('category', 'all');
            $filter_search = trim($request->input('search', ''));

            $query = Equipment::with(['sport', 'category']);

            if ($filter_sport !== 'all' && $filter_sport !== '') {
                $query->whereHas('sport', function ($q) use ($filter_sport) {
                    $q->where('slug', $filter_sport);
                });
            }

            if ($filter_category !== 'all' && $filter_category !== '') {
                $query->whereHas('category', function ($q) use ($filter_category) {
                    $q->where('slug', $filter_category);
                });
            }

            if ($filter_search !== '') {
                $query->where('name', 'like', '%' . $filter_search . '%');
            }

            $equipments = $query->orderBy('id', 'desc')->get();
            $sportsList = Sport::all();
            $categoriesList = Category::all();

            return view('index', compact(
                'equipments',
                'sportsList',
                'categoriesList',
                'filter_sport',
                'filter_category',
                'filter_search'
            ));

        } catch (Throwable $e) {
            Log::error('Katalog error: ' . $e->getMessage());

            return redirect('/katalog')
                ->with('status', 'error')
                ->with('message', $e->getMessage());
        }
    }


    // ==========================================
    // 2. TAMBAH BARANG
    // ==========================================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'sport_id' => 'required|integer|exists:sports,id',
            'category_id' => 'required|integer|exists:categories,id',
            'rental_rate' => 'required|numeric|min:0',
            'unit_type' => 'required|in:hari,jam,sesi',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url|max:2048',
        ]);

        try {
            $equipment = new Equipment();

            $equipment->name = $validated['name'];
            $equipment->sport_id = $validated['sport_id'];
            $equipment->category_id = $validated['category_id'];
            $equipment->rental_rate = $validated['rental_rate'];
            $equipment->unit_type = $validated['unit_type'];
            $equipment->stock = $validated['stock'];
            $equipment->image_url = $validated['image_url'] ?? null;

            $equipment->save();

            return redirect('/katalog')
                ->with('status', 'success')
                ->with('message', 'Barang berhasil ditambahkan.');

        } catch (Throwable $e) {
            Log::error('Gagal tambah barang: ' . $e->getMessage());

            return redirect('/katalog')
                ->with('status', 'error')
                ->with('message', 'Gagal menambahkan barang: ' . $e->getMessage());
        }
    }


    // ==========================================
    // 3. EDIT BARANG
    // ==========================================
    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:equipments,id',
            'name' => 'required|string|max:255',
            'sport_id' => 'required|integer|exists:sports,id',
            'category_id' => 'required|integer|exists:categories,id',
            'rental_rate' => 'required|numeric|min:0',
            'unit_type' => 'required|in:hari,jam,sesi',
            'stock' => 'required|integer|min:0',
            'image_url' => 'nullable|url|max:2048',
        ]);

        try {
            $equipment = Equipment::findOrFail($validated['id']);

            $equipment->name = $validated['name'];
            $equipment->sport_id = $validated['sport_id'];
            $equipment->category_id = $validated['category_id'];
            $equipment->rental_rate = $validated['rental_rate'];
            $equipment->unit_type = $validated['unit_type'];
            $equipment->stock = $validated['stock'];
            $equipment->image_url = $validated['image_url'] ?? null;

            $equipment->save();

            return redirect('/katalog')
                ->with('status', 'success_edit')
                ->with('message', 'Barang berhasil diperbarui.');

        } catch (Throwable $e) {
            Log::error('Gagal edit barang: ' . $e->getMessage());

            return redirect('/katalog')
                ->with('status', 'error')
                ->with('message', 'Gagal mengedit barang: ' . $e->getMessage());
        }
    }


    // ==========================================
    // 4. HAPUS BARANG
    // ==========================================
    public function destroy(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer|exists:equipments,id',
        ]);

        try {
            $equipment = Equipment::findOrFail($validated['id']);
            $equipment->delete();

            return redirect('/katalog')
                ->with('status', 'success_delete')
                ->with('message', 'Barang berhasil dihapus.');

        } catch (Throwable $e) {
            Log::error('Gagal hapus barang: ' . $e->getMessage());

            return redirect('/katalog')
                ->with('status', 'error')
                ->with('message', 'Gagal menghapus barang: ' . $e->getMessage());
        }
    }


    // ==========================================
    // 5. HALAMAN TRANSAKSI
    // ==========================================
    public function transaksi(Request $request)
    {
        try {
            $filter_status = $request->input('status', 'all');
            $filter_search = $request->input('search', '');

            $query = Rental::withCount('items');

            if ($filter_status !== 'all') {
                $query->where('status', $filter_status);
            }

            if ($filter_search !== '') {
                $query->where(function ($q) use ($filter_search) {
                    $q->where('renter_name', 'like', '%' . $filter_search . '%')
                      ->orWhere('renter_phone', 'like', '%' . $filter_search . '%');
                });
            }

            $rentals = $query->orderBy('id', 'desc')->get();

            $equipments = Equipment::where('stock', '>', 0)
                ->orderBy('name', 'asc')
                ->get();

            return view('transaksi', compact(
                'rentals',
                'equipments',
                'filter_status',
                'filter_search'
            ));

        } catch (Throwable $e) {
            Log::error('Transaksi error: ' . $e->getMessage());

            return redirect('/transaksi')
                ->with('error', $e->getMessage());
        }
    }


    // ==========================================
    // 6. TAMBAH TRANSAKSI SEWA
    // ==========================================
    public function storeSewa(Request $request)
    {
        $validated = $request->validate([
            'renter_name' => 'required|string|max:255',
            'renter_phone' => 'required|string|max:30',
            'equipment_id' => 'required|integer|exists:equipments,id',
            'duration_hours' => 'required|integer|min:1',
            'quantity' => 'required|integer|min:1',
            'start_time' => 'required|date',
        ]);

        try {
            DB::beginTransaction();

            $equipment = Equipment::lockForUpdate()
                ->findOrFail($validated['equipment_id']);

            $quantity = $validated['quantity'];
            $duration = $validated['duration_hours'];

            if ($equipment->stock < $quantity) {
                throw new \Exception('Stok barang tidak mencukupi!');
            }

            $rate = $equipment->rental_rate;
            $subtotal = $rate * $duration * $quantity;

            $rental = Rental::create([
                'renter_name' => $validated['renter_name'],
                'renter_phone' => $validated['renter_phone'],
                'start_time' => $validated['start_time'],
                'duration_hours' => $duration,
                'total_amount' => $subtotal,
                'status' => 'ACTIVE',
            ]);

            $rental->items()->create([
                'equipment_id' => $equipment->id,
                'quantity' => $quantity,
                'rate_per_hour' => $rate,
                'subtotal' => $subtotal,
            ]);

            $equipment->decrement('stock', $quantity);

            DB::commit();

            return redirect('/transaksi')
                ->with('status', 'success');

        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal membuat transaksi: ' . $e->getMessage());

            return redirect('/transaksi')
                ->with('error', $e->getMessage());
        }
    }


    // ==========================================
    // 7. SELESAIKAN TRANSAKSI
    // ==========================================
    public function updateStatusSewa(Request $request)
    {
        $rental_id = (int) $request->input('rental_id');
        $action = $request->input('action');

        if ($action === 'complete' && $rental_id > 0) {
            try {
                DB::beginTransaction();

                $rental = Rental::with('items')->findOrFail($rental_id);

                if ($rental->status !== 'COMPLETED') {
                    $rental->update([
                        'status' => 'COMPLETED'
                    ]);

                    foreach ($rental->items as $item) {
                        Equipment::where('id', $item->equipment_id)
                            ->increment('stock', $item->quantity);
                    }
                }

                DB::commit();

                return redirect('/transaksi')
                    ->with('status', 'completed');

            } catch (Throwable $e) {
                DB::rollBack();

                Log::error('Gagal menyelesaikan transaksi: ' . $e->getMessage());

                return redirect('/transaksi')
                    ->with('error', $e->getMessage());
            }
        }

        return redirect('/transaksi');
    }
}
