<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'profile_pic' => 'nullable|image|max:2048',
        ]);
        
        if ($request->hasFile('profile_pic')) {
            $path = $request->file('profile_pic')->store('uploads/profile', 'public');
            $user->profile_pic = $path;
            $user->save();
        }
        
        return redirect()->route('profile.edit')->with('status', 'Profilo aggiornato!');
    }
}
