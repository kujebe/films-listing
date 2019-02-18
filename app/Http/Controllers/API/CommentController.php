<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

use App\Comment;
use App\Film;

class CommentController extends Controller
{

    public function __construct(){

        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return Comment::with('user')->get();
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        Comment::create(request()->validate([
            'comment' => 'required | min:2',
            'film_id' => 'required',
            'owner_id' => 'required '
        ])); 

        return response()->json(['success'=>'Comment Saved'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show($comment)
    {
        //return  CommentResource::collection(Comment::where('id', $comment)->with('user')->get());
    }  
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(comment $comment)
    {
        //
    }
}
