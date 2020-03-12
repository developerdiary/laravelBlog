<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Post;

class PostController extends Controller
{
    public function index(Request $request){

        if($request->ajax())
        {
            $posts = new Post;
            if($request->q)
            {
                $posts = $posts->where('name', 'like', '%'.$request->q.'%');
            }
            $posts = $posts->paginate(config('constant.perpage'))->appends(['q' => $request->q]);       
            return response()->json($posts);
        }
        
        return view('frontend.blog.index');
    }
}
