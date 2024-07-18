<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\CategoryService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SoftwareDevelopmentController extends Controller
{
    public function index()
    {
        $software_development = CategoryService::where('kode', 1)->with(['service'])->get();

        return Inertia::render('Dashboard/Template/SoftwareDevelopment', [
            'software_development' => $software_development
        ]);
    }
}
