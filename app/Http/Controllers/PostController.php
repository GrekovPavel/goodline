<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Jobs\DeleteExpiredPost;

class PostController extends Controller
{
    public function index()
    {
        $posts = $this->getPublicPosts();

        $userPosts = Auth::check() ? $this->getUserPosts() : [];

        return view('welcome', ['posts' => $posts, 'userPosts' => $userPosts]);
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

        $userId = Auth::id();

        $post = Post::create([
            'user_id' => $userId,
            'title' => $request->title,
            'content' => $request->content,
            'expiration_time' => $request->expiration_time,
            'link' => '',
            'access' => $request->access_paste,
        ]);

        $post->update([
            'link' => substr(md5($post->id), 0, 8),
        ]);

        if ($post->expiration_time) {
            DeleteExpiredPost::dispatch()->delay(now()->addMinutes($post->expiration_time));
        }

        return redirect('/' . substr(md5($post->id), 0, 8));
    }

    public function show($hash)
    {
        $post = Post::where('link', $hash)->first();

        if ((!$post) || $post->access == 'private' && $post->user_id != Auth::id()) {
            abort(404);
        }

        $postData = [
            'title' => $post->title,
            'content' => $post->content,
        ];

        $publicPosts = $this->getPublicPosts();

        $userPosts = Auth::check() ? $this->getUserPosts() : [];

        return view('paste', ['postData' => $postData, 'publicPosts' => $publicPosts, 'userPosts' => $userPosts]);
    }

    public function person()
    {
        $publicPosts = $this->getPublicPosts();

        $userPosts =  Auth::check() ? Post::where('user_id', Auth::id())->latest()->paginate(10) : [];

        return view('dashboard', ['publicPosts' => $publicPosts, 'userPosts' => $userPosts]);
    }

    private function getPublicPosts()
    {
        $post = new Post();

        return $post
            ->where('access', 'public')
            ->latest()
            ->limit(10)
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->id => [
                        "user_id" => $item->user_id,
                        "user_name" => $item->user->name ?? "Гость",
                        "title" => $item->title,
                        "content" => $item->content,
                        "expiration_time" => $item->expiration_time,
                        "link" => $item->link,
                        "access" => $item->access,
                    ]
                ];
            })->toArray();
    }

    private function getUserPosts()
    {
        $post = new Post;

        return $post
            ->where('user_id', Auth::id())
            ->latest()
            ->limit(10)
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->id => [
                        "user_id" => $item->user_id,
                        "user_name" => $item->user->name ?? "Гость",
                        "title" => $item->title,
                        "content" => $item->content,
                        "expiration_time" => $item->expiration_time,
                        "link" => $item->link,
                        "access" => $item->access,
                    ]
                ];
            })->toArray();
    }
}
