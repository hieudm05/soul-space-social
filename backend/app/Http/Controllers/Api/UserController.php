<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show($id)
    {
        $user = User::with(['posts', 'followers', 'following'])->findOrFail($id);
        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->id != $id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name' => 'string|max:255',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($request->only('name'));

        return response()->json($user);
    }

    public function follow(Request $request, $id)
    {
        $user = auth()->user();
        if ($user->id == $id) {
            return response()->json(['error' => 'Cannot follow yourself'], 400);
        }

        $user->following()->attach($id);

        return response()->json(['message' => 'Followed']);
    }

    public function unfollow(Request $request, $id)
    {
        $user = Auth::user();
        $user->following()->detach($id);

        return response()->json(['message' => 'Unfollowed']);
    }
}