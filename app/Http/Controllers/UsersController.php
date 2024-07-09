<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
}
