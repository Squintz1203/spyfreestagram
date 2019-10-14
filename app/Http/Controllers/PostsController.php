<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);

        return view('posts/index', ['posts' => $posts]);
    }

    public function create()
    {
        return view('posts/create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        // change 'public' with 's3'
        // $imagePath = request('image')->store('uploads', 'public');

        // $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        // $image->save();

        $image = Image::make(request('image'))->fit(1200, 1200)->encode('jpg', 75);
        $s3 = Storage::disk('s3');

        $image_name = 'uploads-' . request('caption') . '.jpg';
        $image_path = '/uploads/' . $image_name;
        $s3->put($image_path, $image, 'public');

        if ($s3->exists($image_path)) {
            $image_url = $s3->url($image_path);

            auth()->user()->posts()->create([
                'caption' => $data['caption'],
                'image' => $image_url,
            ]);
        }

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(\App\Post $post)
    {
        return view('posts/show', [
            'post' => $post,
        ]);
    }
}
