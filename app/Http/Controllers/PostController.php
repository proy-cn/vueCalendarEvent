<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\File;
use App\Http\Resources\CalendarResource;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return PostResource::collection(
            Post::where('user_id', auth()->user()->id)->latest()->get()
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'file' => 'required | image',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $title = $request->title;
        $category_id = $request->category_id;

        $user_id = auth()->user()->id;
        $body = $request->input('body');
        $imagePath = 'storage/' . $request->file('file')->store('postsImages', 'public');

        $post = new Post();
        $post->title = $title;
        $post->category_id = $category_id;
        $post->user_id = $user_id;
        $post->description = $body;
        $post->cover_image = $imagePath;
        $post->location = $request->location;
        
        $post->start_date = Carbon::parse( $request->input('start_date'))->format('Y-m-d');
        $post->start_time = Carbon::parse($request->input('start_time'))->format('H:i:s');
        $post->end_date = Carbon::parse($request->input('end_date'))->format('Y-m-d');
        $post->end_time = Carbon::parse($request->input('end_time'))->format('H:i:s');
        $post->save();
    }

    public function show(Post $post)
    {
        if(auth()->user()->id != $post->user_id){
            return abort(403);
        }
        return new PostResource($post);
    }

    public function update(Request $request, Post $post)
    {
        if(auth()->user()->id != $post->user_id){
            return abort(403);
        }
        $request->validate([
            'title' => 'required',
            'file' => 'nullable | image',
            'body' => 'required',
            'category_id' => 'required'
        ]);

        $title = $request->title;
        $category_id = $request->category_id;        
        $body = $request->input('body');

        if ($request->file('file')) {
            File::delete($post->cover_image);
            $imagePath = 'storage/' . $request->file('file')->store('postsImages', 'public');
            $post->cover_image = $imagePath;
        }

        $post->title = $title;
        $post->category_id = $category_id;
        $post->description = $body;
        return $post->save();
    }

    public function destroy(Post $post)
    {
        if(auth()->user()->id != $post->user_id){
            return abort(403);
        }
        File::delete($post->cover_image);
        return $post->delete();
    }

    public function calendarPost()
    {
        
        return CalendarResource::collection(
            Post::where('user_id', auth()->user()->id)
            ->latest()
            // ->select('id', 'title', 'start_date', 'end_date','user_id')
            ->get()
        );
    }

}
