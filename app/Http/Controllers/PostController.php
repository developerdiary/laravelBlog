<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Post;
use App\Category;
use App\Tag;

use App;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if($request->ajax())
        {
            $posts = new Post;
            if($request->q)
            {
                $posts = $posts->where('name', 'like', '%'.$request->q.'%');
            }
            $posts = $posts->paginate(config('stisla.perpage'))->appends(['q' => $request->q]);            
            return response()->json($posts);
        }


        return view('admin.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'title' => 'required'
        ]);

        $post = new Post;

        $post->title = $request->title;
        $post->body = $request->description;
        $post->slug = Str::slug($request->title, '-');

        $post->save();
        
        $post->category()->attach($request->category_value);
        $post->tag()->attach($request->tag_value);

        return response()->json($post);  

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required'
        ]);

        $post->title = $request->title;
        $post->body = $request->description;
        $post->slug = Str::slug($request->title, '-');

        $post->save();
        
                
        $post->category()->sync($request->category_value);        
        $post->tag()->sync($request->tag_value);        

        return response()->json($post); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if(!App::environment('demo'))
        {
            $post->delete();
        } else
        {
            return response()->json(['message' => 'User accounts cannot be deleted in demo mode.'], 400);
        }
    }
}
