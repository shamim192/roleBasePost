<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class DashboadController extends Controller
{
    public function dashboard()
    {


        $adminPosts = Post::where('user_id', auth()->id())->get();

        return view('dashboard', compact('adminPosts'));
    }
}
