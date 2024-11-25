<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function show(Idea $idea)
    {
        $idea = Idea::with('user')->find($idea->id);
        return view('ideas.show', [
            'idea' => $idea
        ]);
    }

    public function index()
    {
        $ideas = Idea::with('user')->get();
        return view('ideas.index', compact('ideas'));
    }

    public function store()
    {
        request()->validate([
            'content' => 'required|min:1|max:240'
        ]);
        $content = new Idea();
        $content->content = request()->get('content', null);
        $content->likes = 0;
        $content->user_id = auth()->id();
        $content->save();
        return redirect()->route('dashboard')->with('success', 'Thread Created Successfully');
    }

    public function destroy(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id && !auth()->user()->is_admin) {
            return redirect()->route('ideas.index')->with('error', 'Unauthorized action.');
        }
        $idea->delete();
        return redirect()->route('dashboard')->with('success', 'Thread Deleted Successfully');
    }



    public function edit(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            return redirect()->route('ideas.index')->with('error', 'Unauthorized action.');
        }
        $editing = true;
        return view('ideas.show', compact('idea', 'editing'));
    }

    public function update(Idea $idea)
    {
        if (auth()->id() !== $idea->user_id) {
            return redirect()->route('ideas.index')->with('error', 'Unauthorized action.');
        }
        request()->validate([
            'content' => 'required|min:1|max:240'
        ]);
        $idea->content = request()->get('content', '');
        $idea->save();
        return redirect()->route('idea.show', $idea->id)->with('success', 'Thread Updated Successfully');
    }
}
