<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $categories = Category::where('user_id', $user->id)->get();
        $notes = Note::where('user_id', $user->id)->get();

        $categoryActive = null;

        return view('dashboard', compact('categories', 'notes', 'categoryActive'));
    }

    public function filterByCategory(Request $request, $id)
    {
        $user = $request->user();
        $categories = Category::where('user_id', $user->id)->get();

        $notes = Note::where('user_id', $user->id)
                    ->where('category_id', $id)
                    ->with('category')
                    ->get();

        $categoryActive = $id;//Biến này sử dụng để hiểu thị màu khi category được active tức là ví dụ không truyền categoryActive thì all Note sẽ có bg
        return view('dashboard', compact('categories', 'notes', 'categoryActive'));
    }
}
