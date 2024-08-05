<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use PDF;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::query()->with(['items.service.categoryservices', 'user']);

        if ($request->has('search')) {
            $search = $request->search;
            $transactions->where(function ($query) use ($search) {
                $query->where('invoice_code', 'LIKE', '%' . $search . '%')
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'LIKE', '%' . $search . '%');
                    });
            });
        }

        if ($request->has('status') && $request->status != '') {
            $transactions->where('transactions.status', $request->status);
        }

        if ($request->has('sort_by') && $request->has('sort_order')) {
            if ($request->sort_by === 'user.name') {
                $transactions->join('users', 'transactions.user_id', '=', 'users.id')
                            ->orderBy('users.name', $request->sort_order)
                            ->select('transactions.*');
            } else {
                $transactions->orderBy('transactions.' . $request->sort_by, $request->sort_order);
            }
        } else {
            // Default sorting if no sort_by and sort_order are provided
            $transactions->orderBy('transactions.created_at', 'desc');
        }

        if (Auth::user()->role === 4) {
            $transactions->where('user_id', auth()->id());
        }

        $totalSub = Transaction::sum('total');
        $totalIncome = Transaction::where('status', 'completed')->sum('total');

        return Inertia::render('Dashboard/Transactions/Index', [
            'transactions' => $transactions->paginate(5),
            'filters' => $request->all(['search', 'status', 'sort_by', 'sort_order']),
            'totalIncome' => $totalIncome,
            'totalSub' => $totalSub
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();

        if (!$cart || $cart->items->isEmpty()) {
            return redirect()->back()->withErrors(['cart' => 'Your cart is empty']);
        }

        $total = $cart->items->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $invoiceCode = 'INV-' . random_int(100000, 999999);

        $transaction = Transaction::create([
            'user_id' => auth()->id(),
            'invoice_code' => $invoiceCode,
            'total' => $total,
            'status' => 'pending',
        ]);

        foreach ($cart->items as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'services_id' => $item->services_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

         // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // Create transaction parameters
        $params = [
            'transaction_details' => [
                'order_id' => $invoiceCode,
                'gross_amount' => $total,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            'item_details' => $cart->items->map(function ($item) {
                return [
                    'id' => $item->product->id,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->name,
                ];
            })->toArray(),
        ];

        $snapToken = Snap::getSnapToken($params);

        $transaction->midtrans_token = $snapToken;
        $transaction->save();

        // Clear cart after transaction
        $cart->items()->delete();

        return redirect()->route('transactions.show', $transaction->id)->with('success', 'Lanjut Pembayaran');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction = Transaction::with(['items.service.categoryservices', 'user'])->findOrFail($transaction->id);

        $midtransClientKey = config('midtrans.client_key');

        return Inertia::render('Dashboard/Transactions/Show', [
            'transactions' => $transaction,
            'midtransClientKey' => $midtransClientKey,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Transaction $transaction)
    {
        $transaction->status = 'completed';
        $transaction->save();

        // Kirim notifikasi ke pengguna
        // $transaction->user->notify(new TransactionStatusUpdated($transaction));

        return redirect()->route('transactions.index')->with('success', 'Terimakasih Sudah Melakukan Pembayaran');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }

    public function generatePDF(Transaction $transaction)
    {
        $transaction = Transaction::with(['items.service.categoryservices', 'user'])->findOrFail($transaction->id);

        $data = [
            'date' => date('m/d/Y'),
            'transactions' => $transaction,
        ];

        $pdf = Pdf::loadView('pdf.CetakInvoice', $data);
        
        return $pdf->stream('document.pdf');
    }
}
