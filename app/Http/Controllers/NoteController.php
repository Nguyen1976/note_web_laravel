<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {   
        $user = $request->user();
        $categories = Category::where('user_id', $user->id)->get();
        return view('notes.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request);
        // 1. Validate dữ liệu đầu vào từ form
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|integer|exists:categories,id', 
        ]);

        $note = new Note();
        $note->title = $validatedData['title'];
        $note->content = $validatedData['content'];
        $note->category_id = $validatedData['category_id']; 

        if (Auth::check()) {
            $note->user_id = Auth::id();
        } else {
            //return về trang login
            redirect()->route('auth.login');
        }

        $note->save();
        return redirect()->route('dashboard')
                         ->with('success', 'Ghi chú đã được tạo thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
