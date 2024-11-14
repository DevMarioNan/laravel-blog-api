<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class PostController extends Controller implements HasMiddleware
{

    public static function middleware(){
        return [
            new Middleware('auth:sanctum', except: ['index','show'])
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $post = new Post([
            'user_id' => $request->user_id,
            'title' => $request->title,
            'content'=> $request->content
        ]);
        $post->save();
        
        return response()->json(['status'=>201,'message'=>'Post created successfully!'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $post = Post::find($id);
        if($post){
            return response()->json($post);
        }else{
            return response()->json(["message"=>'no post found with id:'.$id],404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(!$request->filled('title') || !$request->filled('content')){
            return response()->json(['message'=>'all fields are required'],422);
        }
        $post = Post::find($id);
        if($post){
            $post->title = $request->title;
            $post->content = $request->content;
            $post->save();
            return response()->json(["message"=>"post updated successfully!"],200);
        }else{
            return response()->json(['message'=>'the post you are trying to update cannot be found!'],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::find($id);
        if($post){
            $post->delete();
            return response()->json(['post deleted successfully!'],200);
        }else{
            return response()->json(['post can\'t be found to be deleted!'],404);
        }
    }
    
    public function user(string $post){
        $post = Post::find($post);
        if($post){
            $user = $post->user()->get();
            return response()->json($user);
        }else{
            return response()->json(['post can\'t be found to find it\'s user!'],404);
        }
    }

    public function comments(string $post){
        $post = Post::find($post);
        if($post){
            $comments = $post->comments()->get();
            return response()->json($comments);
        }else{
            return response()->json(['post can\'t be found to find it\'s comments'],404);
        }
    }
}
