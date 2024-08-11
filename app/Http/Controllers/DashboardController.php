<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Traits\QuoteOfTheDay;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    use QuoteOfTheDay;

    public function index()
    {
         // GET QuoteOfTheDay
        $getQuote = $this->getQuote();

        return Inertia::render('Dashboard', [
            'getQuote' => $getQuote
        ]);
    }
}
