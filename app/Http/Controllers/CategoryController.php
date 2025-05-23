<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $user = $request->user();

        $categories = Category::where('user_id', $user->id)->get();
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
   public function create()
    {   
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string',
        ]);

        $category = new Category();
        $category->name = $validatedData['name'];
        $category->color = $validatedData['color'];
        $category->user_id = Auth::id();

        $category->save();
        return redirect()->route('categories.index')
                         ->with('success', 'Category đã được tạo thành công!');
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
    public function destroy(Category $category)
    {
        // 2. Xóa ghi chú
        $category->delete();

        // 3. Chuyển hướng người dùng với thông báo thành công
        return redirect()->route('categories.index')
                         ->with('success', 'Ghi chú đã được xóa thành công!');
    }
}
