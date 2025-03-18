<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $posts = Post::with(['user', 'likes', 'comments.user'])->latest()->get();

        return view('home', compact('posts'));
    }
}
