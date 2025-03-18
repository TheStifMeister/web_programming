<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->get('query');
        $currentUserId = Auth::id();

        $users = User::where('id', '!=', $currentUserId)
                     ->where(function($q) use ($query) {
                         $q->where('name', 'LIKE', '%' . $query . '%')
                           ->orWhere('username', 'LIKE', '%' . $query . '%');
                     })
                     ->get();

        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return view('profile.show', compact('user'));
    }
}
