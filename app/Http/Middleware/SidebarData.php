<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;
use App\Http\Controllers\CartController;

class SidebarData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Buat instance dari SidebarController
        $cartController = new CartController();
        
        // Panggil metode yang mengambil data sidebar
        $cart = $cartController->getCart();

        // Bagikan data ke setiap response Inertia
        Inertia::share('cart', $cart);

        return $next($request);
    }
}
