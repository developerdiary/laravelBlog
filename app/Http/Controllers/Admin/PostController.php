<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Post;
use App\Category;
use App\Tag;
use App\Gallery;

use App;
use Validator;

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
        
        $input = $request->get('input');

        $rules = [            
            'title' => 'required',
            'subtitle' => 'required',            
        ];
        
        $validator = Validator::make($input, $rules);
        
        if($validator->fails()){
            return response()->json($validator->errors()->messages(), 422);            
        }
        
        $fileName = '';

        if($input['featured_image'])
        {
            $image = $input['featured_image'];
            $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];            
            \Image::make($input['featured_image'])->save(public_path('images/').$fileName);
        }
        
        $post = new Post;

        $post->title = $input['title'];
        $post->subtitle = $input['subtitle'];        
        $post->body = $input['description'];
        $post->image = $fileName;  
        $post->is_published = $request->get('status');
        $post->slug = Str::slug($input['title'], '-');
        $post->features = json_encode($input['features']);

        $post->save();
        
        $post->category()->attach($input['category_value']);
        $post->tag()->attach($input['tag_value']);  
        
        if($input['gallery'])
        {   
            foreach($input['gallery'] as $key => $file){                

                $fileName = time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];  
                \Image::make($file)->save(public_path('images/').$fileName);

                $gallery = new Gallery([
                    'name' => $fileName
                ]);

                $post->gallery()->save($gallery);
            }
        }

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

        if($post->image){
            $file_type = $this->get_extension($post->image);	    
            $post->ogimage = $post->image;
            $post->image = $this->base64_encode_image(public_path('images/').$post->image, $file_type);            
        }            

        foreach($post->gallery as $value){

            $file_type = $this->get_extension($value->name);
            $value->name = $this->base64_encode_image(public_path('images/').$value->name, $file_type);
        }

        $post->features = json_decode($post->features, true);
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
        $input = $request->get('input');


        $rules = [            
            'title' => 'required',
            'subtitle' => 'required',            
        ];
        
        $validator = Validator::make($input, $rules);
        
        if($validator->fails()){
            return response()->json($validator->errors()->messages(), 422);            
        }

        
        $fileName = '';
        
        if($input['featured_image'])
        {           
            if($input['change_image'] != $post->image){                
                $image = $input['featured_image'];
                unlink(public_path('images/').$post->image);
                $fileName = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];            
                \Image::make($input['featured_image'])->save(public_path('images/').$fileName);
                $post->image = $fileName; 
            }else{
                $post->image = $input['change_image'];
            }            
        }else{
            $post->image = $fileName;
        }

        $post->title = $input['title'];
        $post->subtitle = $input['subtitle'];        
        $post->body = $input['description'];         
        $post->is_published = $request->get('status');
        $post->slug = Str::slug($input['title'], '-');
        $post->features = json_encode($input['features']);

        $post->save();
                
        $post->category()->sync($input['category_value']);        
        $post->tag()->sync($input['tag_value']);  
        

        if($post->gallery){
            $post->gallery()->delete();
            foreach($post->gallery as $value){
                unlink(public_path('images/').$value->name);
            }
        }
        
        if($input['gallery'])
        {   
            foreach($input['gallery'] as $key => $file){                

                $fileName = 'g'.time().'.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];  
                \Image::make($file)->save(public_path('images/').$fileName);

                $gallery = new Gallery([
                    'name' => $fileName
                ]);

                $post->gallery()->save($gallery);
            }
        }

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


    function get_extension($file) {

        $extension = explode(".", $file);
        $extension = $extension[1];
        return $extension ? $extension : false;
    }

    function base64_encode_image($filename=string, $filetype=string){
        if ($filename) {
            $imgbinary = fread(fopen($filename, "r"), filesize($filename));
                return 'data:image/' . $filetype 
                        . ';base64,' . base64_encode($imgbinary);
        }
    }

}
