<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Service;
use App\Models\SubService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
// use App\Http\Requests\Hub\SubServiceRequest;
use App\Http\Requests\SubService\SubServiceRequest;


class SubServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // GET services
        $services = Service::query()->orderBy('id');
        // GET Sub Service
        $subService = SubService::query()->orderBy('id');

        if ($request->has('search')) {
            $subService->where('title', 'LIKE', '%' . $request->search . '%');
        }

        return Inertia::render('Dashboard/SubService/Index', [
            'sub_service' => $subService,
            'services' => $services,
            'filters' => $request->all(['search'])
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
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if (!empty($request->hasFile('image'))) {
            $imageFile = $request->file('image');
            $imageName = Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->storeAs('public/images', $imageName);
        } else {
            $imageFile = 'default-user.png';
        }

        $subService = new SubService();
        $subService->title = $request->title;
        $subService->description = $request->title;
        $subService->logo = $imageFile;
        $subService->save();

        return redirect()->back()->with('success', 'Image uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(SubService $subService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SubService $subService)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SubService $subService)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubService $subService)
    {
        //
    }
}
