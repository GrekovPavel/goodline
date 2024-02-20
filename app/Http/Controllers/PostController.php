<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $post = new Post();

        $posts = $post
            ->where('access', 'public')
            ->latest()
            ->limit(10)
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->id => [
                        "user_id" => 0,
                        "title" => $item->title,
                        "content" => $item->content,
                        "expiration_time" => $item->expiration_time,
                        "link" => $item->link,
                        "access" => $item->access,
                    ]
                ];
            })->toArray();

        return view('welcome', ['posts' => $posts]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string | required | min:3 | max: 12',
            'content' => 'string | required | min:3 | max: 500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $post = Post::create([
            'user_id' => 0,
            'title' => $request->title,
            'content' => $request->content,
            'expiration_time' => $request->expiration_time,
            'link' => '',
            'access' => $request->access_paste,
        ]);

        $post->update([
            'link' => substr(md5($post->id), 0, 8),
        ]);

        return redirect('/');
    }

    public function show($hash)
    {
        $post = Post::where('link', $hash)->first();

        if (!$post) {
            abort(404);
        }

        return view('welcome', ['post' => $post]);
    }
}
