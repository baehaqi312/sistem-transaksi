<?php

namespace App\Http\Controllers;

use App\Traits\RoleName;
use App\Models\User;
use App\Http\Requests\Users\UserStoreRequest;
use App\Http\Requests\Users\UserUpdateRequest;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class UsersController extends Controller
{
    use RoleName;

    public function index(Request $request)
    {
        if (Auth::user()->role === 1 or Auth::user()->role === 2) {
            $users = User::query();
    
            if ($request->has('search')) {
                $users->where('name', 'LIKE', '%' . $request->search . '%');
                $users->orwhere('email', 'LIKE', '%' . $request->search . '%');
            }
    
            return Inertia::render('Dashboard/Users/Users', [
                'users' => $users->paginate(),
                'filters' => $request->all(['search'])
            ]);
        } else {
            abort(403);
        }
    }

    public function store(UserStoreRequest $request){
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
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
                'phone' => $request->phone,
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'role' => $request->role,
                'avatar' => null,
                'status' => 1,
            ]);
            DB::commit();
    
            return back()->with('success', $user->name . ' Sukses Diupdate');

        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('errors', $th->getMessage());
        }
    }

    public function destroy(User $user)
    {
        try {

            $user->delete();

            return back()->with('success', $user->name . ' Sukses Dihapus');

        } catch (\Throwable $th) {
            DB::rollBack();

            return back()->with('errors', $th->getMessage());
        }
    }
}
