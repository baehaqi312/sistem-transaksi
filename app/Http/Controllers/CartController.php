<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::where('user_id', auth()->id())->with('items.product')->first();
        return Inertia::render('Dashboard/Cart/Index', [
            'cart' => $cart
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $service = Service::find($request->services_id);
        if (!$service) {
            return redirect()->back()->withErrors(['services_id' => 'Invalid service ID']);
        }

        $cart = Cart::firstOrCreate(['user_id' => auth()->id()]);

        $cartItem = $cart->items()->where('services_id', $service->id)->first();

        if ($cartItem) {
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            $cart->items()->create([
                'services_id' => $service->id,
                'quantity' => $request->quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Service updated successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $cartItem->delete();
        return back()->with('success', ' Sukses Dihapus');
    }
}
