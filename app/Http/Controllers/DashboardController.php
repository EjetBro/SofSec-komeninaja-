<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idea;

class DashboardController extends Controller
{
    public function index(){
        $ideas = Idea::orderBy('created_at', 'desc')->paginate(12);
        return view('dashboard', [
            'ideas' => $ideas
        ]);
    }
}
