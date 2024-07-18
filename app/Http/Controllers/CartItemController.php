<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;

class CartItemController extends Controller
{
    public function destroy(CartItem $cartItem)
    {
        /// Pastikan relasi cart ada
        // if (!$cartItem->cart) {
        //     return redirect()->route('cart.index')->withErrors(['error' => 'Cart not found.']);
        // }

        // Periksa apakah pengguna yang mencoba menghapus item adalah pemilik keranjang
        // if ($cartItem->cart->user_id !== auth()->id()) {
        //     return redirect()->route('cart.index')->withErrors(['error' => 'Unauthorized action.']);
        // }

        // Hapus item dari keranjang
        $cartItem->delete();
        return back()->with('success', ' Sukses Dihapus');
    }
}
