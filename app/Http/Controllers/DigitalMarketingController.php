<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\CategoryService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DigitalMarketingController extends Controller
{
    public function index()
    {
        $digital_marketing = CategoryService::where('kode', 2)->with(['service'])->get();

        return Inertia::render('Dashboard/Template/DigitalMarketing', [
            'digital_marketing' => $digital_marketing
        ]);
    }
}
