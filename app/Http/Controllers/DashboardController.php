<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Service;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Traits\QuoteOfTheDay;
use App\Models\CategoryService;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    use QuoteOfTheDay;

    public function index()
    {
         // GET QuoteOfTheDay
        $getQuote = $this->getQuote();

        $services = Service::count();
        $users = User::count();
        $transactions = Transaction::count();
        $transactionsAdmin = Transaction::where('status', 'completed')->sum('total');
        $totalTransactions = Transaction::where('status', 'completed')->count();
        $category_services = CategoryService::get();

        if (Auth::user()->role === 4) {
            $transactions = Transaction::where('user_id', auth()->id())->count();
        }

        return Inertia::render('Dashboard', [
            'getQuote' => $getQuote,
            'services' => $services,
            'users' => $users,
            'transactions' => $transactions,
            'transactionsAdmin' => $transactionsAdmin,
            'totalTransactions' => $totalTransactions,
            'category_services' => $category_services,
        ]);
    }
}
