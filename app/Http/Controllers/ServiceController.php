<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Service;
use App\Models\CategoryService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $service = Service::query();

        $category_service = CategoryService::orderBy('id', 'DESC')->get();

        if ($request->has('search')) {
            $service->where('name', 'LIKE', '%' . $request->search . '%');
        }

        return Inertia::render('Dashboard/Service/Index', [
            'service' => $service->with('categoryservices')->paginate(10),
            'category_service' => $category_service,
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
            // 'category_id' => 'required|uuid|exists:category_services,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            // 'duration' => 'required|integer|min:0',
        ]);

        $service = new Service();
        $service->name = $request->name;
        $service->description = $request->description;
        $service->category_id = $request->category_id;
        $service->price = $request->price;
        // $service->duration = $request->duration;

        $service->save();

        return redirect()->back()->with('success', 'Category Service uploaded successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
        ]);
    
        $service->name = $request->name;
        $service->description = $request->description;
        $service->category_id = $request->category_id;
        $service->price = $request->price;
    
        $service->save();
    
        return redirect()->back()->with('success', 'Service updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Service $service)
    {

        $service->cartItems()->delete();
        $service->delete();

        return back()->with('success', $service->name . ' Sukses Dihapus');
    }
}
