<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        try {
            $user = $request->user();
    
            $categories = Category::where('user_id', $user->id)->get();
            $notes = Note::where('user_id', $user->id)->with('category')->with('reminder')->get();
    
            $categoryActive = null;
    
            return view('dashboard', compact('categories', 'notes'));
        } catch (\Exception $e) {
            throw $e; 
        }
    }

    // public function filterByCategory(Request $request, $id)
    // {
    //     try {
    //         $user = $request->user();
    //         $categories = Category::where('user_id', $user->id)->get();
    
    //         $notes = Note::where('user_id', $user->id)
    //                     ->where('category_id', $id)
    //                     ->with('category')
    //                     ->with('reminder')
    //                     ->get();
    
    //         $categoryActive = $id;
    //         return view('dashboard', compact('categories', 'notes', 'categoryActive'));
    //     } catch (\Exception $e) {
    //         throw $e; 
    //     }
    // }
}
