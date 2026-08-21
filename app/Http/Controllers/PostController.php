<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): Response
    {
        $posts = Post::all();

        return view('post.index', [
            'posts' => $posts,
        ]);
    }
}
