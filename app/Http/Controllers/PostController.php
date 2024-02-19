<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function store(Request $request)
    {
        Post::create([
            'user_id' => 0,
            'title' => $request->title,
            'content' => $request->content,
            'expiration_time' => $request->expiration_time,
            'link' => 3,
            'access' => $request->access_paste,

        ]);

    }
}
