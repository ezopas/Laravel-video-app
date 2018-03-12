<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
//kad galetume manipuliuoti failais
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    public function index()
    {
        //$posts = Post::all();
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        return view('posts.index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.upload');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'cover_image' => 'image|nullable|max:1999',
            'source' => 'required|max:1000000'
        ]);

        if($request->hasFile('cover_image')){
            $fullfilename = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($fullfilename, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $storefilename = $filename.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $storefilename);
        }else{
            $storefilename = 'noimage.jpg';
        }

        if($request->hasFile('source')){
            $fullfilename = $request->file('source')->getClientOriginalName();
            $filename = pathinfo($fullfilename, PATHINFO_FILENAME);
            $extension = $request->file('source')->getClientOriginalExtension();
            $storevideoname = $filename.'_'.time().'.'.$extension;
            $path = $request->file('source')->storeAs('public/video', $storevideoname);
        }else{
            return redirect('/posts')->with('error', 'Video must added');
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        //$post->password = $request->input('password');
        $post->password = 0;
        $post->views = 0;
        $post->user_id = auth()->user()->id;
        $post->source = $storevideoname;
        $post->cover_image = $storefilename;
        $post->save();

        return redirect('/posts')->with('success', 'Video upladed');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);

        //jeigu neranda id su video metam 404 klaida
        if(!isset($post)){
            abort(404);
        }

        //add count
        $count = $post->views;
        $post->views = $count+1;
        $post->save();

        $posts = Post::orderBy('id', 'desc')->get();

        $data = ['post' => $post, 'posts' => $posts];

        return view('posts.show')->with($data);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized accsess');
        }

        return view('posts.edit')->with('post', $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            //'cover_image' => 'image|nullable|max:1999',
        ]);
        //return $request->input('cover_image');
        if($request->hasFile('cover_image')){
            $fullfilename = $request->file('cover_image')->getClientOriginalName();
            $filename = pathinfo($fullfilename, PATHINFO_FILENAME);
            $extension = $request->file('cover_image')->getClientOriginalExtension();
            $storefilename = $filename.'_'.time().'.'.$extension;
            $path = $request->file('cover_image')->storeAs('public/cover_images', $storefilename);
        }else{
            $storefilename = 'noimage.jpg';
        }



        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->description = $request->input('description');
        $post->cover_image = $storefilename;
//        if(empty($request->input('password'))){
//            $post->password = 0;
//        }else{
//            $post->password = $request->input('password');
//
//        }
        $post->password = 0;
        $post->save();

        return redirect('/posts')->with('success', 'Video Post Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/posts')->with('error', 'Unauthorized accsess');
        }

        //rodom ka turim
        //$files = Storage::allFiles("/");
        //return $files;

        //trinam foto ir video
        $s = "public/cover_images/".$post->cover_image;
        $v = "public/video/".$post->source;
        Storage::delete([$s, $v]);

        $post->delete();

        return redirect('/posts')->with('success', 'Video Deleted');
    }
}
