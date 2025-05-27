<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        try {
            $user = $request->user();
            $categories = Category::where('user_id', $user->id)->get();
            return view('categories.index', compact('categories'));
        } catch (\Exception $e) {
            throw $e;
        }
        
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
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'color' => 'required|string',
            ]);

            $category = new Category();
            $category->name = $validatedData['name'];
            $category->color = $validatedData['color'];
            $category->user_id = Auth::id();

            $category->save();

            Alert::success('Success', 'Category created successfully!');
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            throw $e;
        }
        
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
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'color' => 'required|string',
            ]);

            $category->name = $validatedData['name'];
            $category->color = $validatedData['color'];

            $category->save(); 

            Alert::success('Success', 'Category has been updated successfully!');

            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            throw $e;
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();
    
            Alert::success('Success', 'Category deleted successfully!');
            return redirect()->route('categories.index');
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
