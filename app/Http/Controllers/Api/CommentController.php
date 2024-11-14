<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class CommentController extends Controller implements HasMiddleware
{

    public static function middleware(){
        return [
            new Middleware('auth:sanctum',except: ['index','show'])
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::all();
        return response()->json($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $comment = new Comment([
            'post_id'=>$request->post_id,
            'user_id'=>$request->user_id,
            'content'=>$request->content
        ]);

        $comment->save();
        return response()->json(['message'=>'comment saved successfully!','comment'=>$comment]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::find($id);
        if($comment)return response()->json($comment,200);
        else return response()->json(['message'=>'comment not found!'],404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::find($id);
        if(!$comment){
            return response()->json([
                'message'=>'comment not found!'
            ]);
        }
        $comment->content = $request->content;

        $comment->save();
        return response()->json([
            'message'=>'comment saved successfully!',
            'comment'=>$comment
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        if($comment){
            $comment->delete();
            return response()->json([
                'message'=>'comment deleted successfully!'
            ],200);
        }else{
            return response()->json([
                'message'=>'comment not found!'
            ],404);
        }
    }

    public function user(string $id){
        $comment = Comment::find($id);
        if($comment){
            $user = $comment->user()->get();
            return response()->json($user);
        }else return response()->json([
            "message"=>'there was an error!'
        ],404);
    }

    public function post(string $id){
        $comment = Comment::find($id);
        if($comment){
            $post = $comment->post()->get();
            return response()->json($post);
        }else return response()->json([
            "message"=>'there was an error!'
        ],404);
    }
}
