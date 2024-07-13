<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\CategoryService;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category_services = CategoryService::query();

        if ($request->has('search')) {
            $category_services->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return Inertia::render('Dashboard/CategoryService/Index', [
            'category_services' => $category_services->paginate(10),
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
            'name' => 'required|string|max:255',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // $imageFile = $request->file('image');
        // $imageName = Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
        // $imageFile->storeAs('public/images', $imageName);

        $category_services = new CategoryService();
        $category_services->name = $request->name;
        // $category_services->icon = 'images/' . $imageName;
        $category_services->save();

        return redirect()->back()->with('success', 'Category Service uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoryService $categoryService)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryService $categoryService)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CategoryService $categoryService)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
    
        $categoryService->name = $request->name;
        $categoryService->save();

        // $service = Team::find($user->service->id);

        $service = Service::where('category_id', $categoryService->id)->firstOrCreate(['category_id' => $categoryService->id]);
        // $service->category_id = $request->service;
        $service->save();
    
        return redirect()->back()->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoryService $categoryService)
    {

        // Delete related rows in the `services` table via the relationship
        $categoryService->service()->delete();

        // Then, delete the category
        $categoryService->delete();

        return back()->with('success', $categoryService->name . ' Sukses Dihapus');
    }
}
