<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user('id');
        //$user = DB::select("SELECT * FROM `posts` WHERE `user_id` = ".$user_id->id);
        $user = Post::where("user_id", "=", $user_id->id)->get();

        //return $posts;
        return view('dashboard')->with('posts', $user);
    }
}
