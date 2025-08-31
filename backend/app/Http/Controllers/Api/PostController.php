<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'comments', 'reactions'])
            ->where('status', 'published')
            ->whereIn('user_id', auth()->user()->following()->pluck('id'))
            ->orWhere('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        // dd($posts);
        // return view('posts.index', compact('posts'));

        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::with(['user', 'comments', 'reactions'])
            ->where('status', 'published')
            ->findOrFail($id);

        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'user_id' => Auth::id(),
            'content' => $request->content,
            'status' => 'published',
        ];

        if ($request->hasFile('image')) {
            $data['image_url'] = $request->file('image')->store('posts', 'public');
        }

        $post = Post::create($data);

        return response()->json($post, 201);
    }
}
