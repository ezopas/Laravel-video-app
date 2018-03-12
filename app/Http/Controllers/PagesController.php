<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PagesController extends Controller
{
    public function index(){

        $posts = Post::orderBy('id', 'desc')->take(6)->get();
        $viewed = Post::orderBy('views', 'desc')->take(6)->get();

        $data = ['posts' => $posts, 'views' => $viewed];

        return view('pages.index')->with($data);
    }

    public function embed($id){

        $post = Post::find($id);

        //jeigu neranda id su video metam 404 klaida
        if(!isset($post)){
            abort(404);
        }

        //add count
        $count = $post->views;
        $post->views = $count+1;
        $post->save();

        $posts = Post::orderBy('id', 'desc')->take(6)->get();

        $data = ['post' => $post, 'posts' => $posts];

        return view('pages.embed')->with($data);
    }
}
