<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;


class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        $postsCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->posts->count();
            }
        );

        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->profile->followers->count();
            }
        );
        $followingCount = Cache::remember(
            'count.following.' . $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->following->count();
            }
        );

        return view(
            'profiles/index',
            compact('user', 'follows', 'postsCount', 'followersCount', 'followingCount')
        );
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles/edit', ['user' => $user]);
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);


        if (request('image')) {
            $image = Image::make(request('image'))->fit(1000, 1000)->encode('jpg', 75);
            $s3 = Storage::disk('s3');

            $image_name = 'profile-pic-id-' . $user->id . '.jpg';
            $image_path = '/profile/' . $image_name;
            $s3->put($image_path, $image, 'public');

            if ($s3->exists($image_path)) {
                $image_url = $s3->url($image_path);
                $image_array = ['image' => $image_url];
            }
        }

        auth()->user()->profile->update(array_merge($data, $image_array ?? []));

        return redirect("/profile/{$user->id}");
    }
}
