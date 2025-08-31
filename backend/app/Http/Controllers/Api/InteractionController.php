<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Comment;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InteractionController extends Controller
{
    public function like(Request $request, $postId)
    {
        $request->validate([
            'post_id' => 'exists:posts,id',
        ]);

        $like = Reaction::firstOrCreate([
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);

        return response()->json($like, 201);
    }

    public function comment(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string',
            'post_id' => 'exists:posts,id',
        ]);

        $comment = Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $postId,
            'content' => $request->content,
        ]);

        return response()->json($comment, 201);
    }
}