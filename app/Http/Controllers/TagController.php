<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
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
            $tags = new Tag;
            if($request->q)
            {
                $tags = $tags->where('name', 'like', '%'.$request->q.'%');
            }
            $tags = $tags->paginate(config('stisla.perpage'))->appends(['q' => $request->q]);
            return response()->json($tags);
        }

        return view('admin.tag.index');
    }

    public function getAllTags(Request $request)
    {
        
        $tags = Tag::all();
        return response()->json($tags);

    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.tag.create');
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
            'name' => 'required'
        ]);      
        
        $tag = new Tag;

        $tag->name = $request->name;

        $tag->save();

        return response()->json($tag);   
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        return view('admin.tag.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        
        $request->validate([
            'name' => 'required'
        ]); 
        
        $tag->name = $request->name;

        $tag->save();

        return response()->json($tag); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {   
        if(!App::environment('demo'))
        {
            $tag->delete();
        } else
        {
            return response()->json(['message' => 'User accounts cannot be deleted in demo mode.'], 400);
        }
    }
}
