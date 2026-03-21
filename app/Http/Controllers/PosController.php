<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('pos.index', compact('products'));
    }

    public function history(Request $request)
    {
        $query = Transaction::query();
        if ($request->range == 'hari') {
            $query->whereDate('created_at', now()->today());
        } elseif ($request->range == 'minggu') {
            $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        }

        $transactions = $query->orderBy('created_at', 'desc')->get();
        return view('history', compact('transactions'));
    }

    public function analytics()
    {
        $earningToday = Transaction::whereDate('created_at', now()->today())->sum('total_price');
        $count = Transaction::whereDate('created_at', now()->today())->count();
        $earningWeek = Transaction::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price');
        $earningMonth = Transaction::whereMonth('created_at', now()->month)->sum('total_price');

        $allTransactions = Transaction::all();
        $productStats = [];

        foreach ($allTransactions as $t) {
            $items = is_array($t->items) ? $t->items : json_decode($t->items, true);
            if ($items) {
                foreach ($items as $item) {
                    $name = $item['name'] ?? 'Unknown';
                    $qty = $item['qty'] ?? 0;
                    $price = $item['price'] ?? 0;

                    if (!isset($productStats[$name])) {
                        $productStats[$name] = ['qty' => 0, 'revenue' => 0, 'price' => $price];
                    }
                    $productStats[$name]['qty'] += $qty;
                    $productStats[$name]['revenue'] += ($qty * $price);
                }
            }
        }

        // Urutkan produk terlaris
        uasort($productStats, function ($a, $b) {
            return $b['qty'] <=> $a['qty']; });

        $bestSeller = !empty($productStats) ? array_key_first($productStats) : 'Belum ada data';
        $bestSellerQty = !empty($productStats) ? reset($productStats)['qty'] : 0;

        return view('analytics', compact('earningToday', 'count', 'earningWeek', 'earningMonth', 'productStats', 'bestSeller', 'bestSellerQty'));
    }

    public function store(Request $request)
    {
        try {
            $transaction = new Transaction();
            $transaction->invoice_number = $this->generateInvoice();
            $transaction->total_price = $request->total_price;
            $transaction->items = $request->items; // Pastikan ini tersimpan sebagai JSON/Array
            $transaction->paid_amount = $request->total_price;
            $transaction->change_amount = 0;
            $transaction->save();

            return response()->json(['success' => true, 'invoice' => $transaction->invoice_number]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function generateInvoice()
    {
        $last = Transaction::orderBy('id', 'desc')->first();
        if (!$last)
            return 'AAA-000';
        $parts = explode('-', $last->invoice_number);
        if (count($parts) < 2)
            return 'AAA-000';
        $letters = $parts[0];
        $number = intval($parts[1]);
        if ($number < 999) {
            $number++;
        } else {
            $number = 0;
            $letters++;
        }
        if (strlen($letters) > 3)
            $letters = 'AAA';
        return $letters . '-' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }

    public function clearAll()
    {
        Schema::disableForeignKeyConstraints();
        Transaction::truncate();
        Schema::enableForeignKeyConstraints();
        return redirect()->route('history')->with('success', 'Data dibersihkan!');
    }

    public function destroy($id)
    {
        Transaction::findOrFail($id)->delete();
        return back()->with('success', 'Berhasil dihapus');
    }
}