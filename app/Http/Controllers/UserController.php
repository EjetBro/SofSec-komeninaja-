<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Idea;
use App\Models\Like;

class UserController extends Controller
{
    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile_picture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $user = auth()->user();

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::delete($user->profile_picture);
            }
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function likeIdea(Request $request, $ideaId)
    {
        $idea = Idea::findOrFail($ideaId);
        $user = auth()->user();
        $like = Like::where('user_id', $user->id)->where('idea_id', $idea->id)->first();

        if ($like) {
            $like->delete();
            $message = 'You Unliked This Thread';
        } else {
            $like = new Like();
            $like->user_id = $user->id;
            $like->idea_id = $idea->id;
            $like->save();
            $message = 'You Liked This Thread';
        }

        return redirect()->back()->with('success', $message);
    }

    public function index()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(404);
        }

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function ban(User $user)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(404);
        }

        $user->is_banned = 1;
        $user->save();
        return redirect()->route('admin.users.index')->with('success', 'User Banned Successfully');
    }

    public function unban(User $user)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            abort(404);
        }

        $user->is_banned = 0;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User Unbanned Successfully');
    }

    public function makeAdmin(User $user)
    {
        $user->is_admin = 1;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User Made Admin Successfully');
    }

    public function removeAdmin(User $user)
    {
        $user->is_admin = 0;
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Admin Role Removed Successfully');
    }

}
