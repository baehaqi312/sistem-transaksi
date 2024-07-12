<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UsersController extends Controller
{
    public function index(Request $request){
        $users = User::query();

        if ($request->has('search')) {
            $users->where('name', 'LIKE', '%' . $request->search . '%');
            $users->orwhere('email', 'LIKE', '%' . $request->search . '%');
        }

        return Inertia::render('Users/Users', [
            'users' => $users->paginate(),
            'filters' => $request->all(['search'])
        ]);
    }

    public function store(UserStoreRequest $request){
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'avatar' => null,
                'status' => 1,
            ]);
            DB::commit();
    
            return back()->with('success', $user->name . ' sukses ditambahkan');

        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('errors', $th->getMessage());
        }
        
    }

    public function update(UserUpdateRequest $request, string $id){
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'role' => $request->role,
                'avatar' => null,
                'status' => 1,
            ]);
            DB::commit();
    
            return back()->with('success', $user->name . ' sukses diupdate');

        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('errors', $th->getMessage());
        }
        

    }
}
