<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use App\Models\Reminder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use RealRashid\SweetAlert\Facades\Alert;

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
        try {
            $user = $request->user();
            $categories = Category::where('user_id', $user->id)->get();
            $reminders = Reminder::where('user_id', $user->id)->get();
            return view('notes.create', compact('categories', 'reminders'));
        } catch (\Exception $e) {
            throw $e; 
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|min:5|max:255',
                'content' => 'required|string|min:10|max:1000',
                'category_id' => 'nullable|integer|exists:categories,id', 
                'reminder_id' => 'nullable|integer|exists:reminders,id', 
            ]);
    
            $note = new Note();
            $note->title = $validatedData['title'];
            $note->content = $validatedData['content'];
            $note->category_id = $validatedData['category_id'] ?? null;
            $note->reminder_id = $validatedData['reminder_id'] ?? null;
    
            $note->user_id = Auth::id();
          
    
            $note->save();
            Alert::success('success', 'Note created successfully!');
    
            return redirect()->route('dashboard');
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
    public function edit(Note $note)
    {
        try {
            $categories = Category::where('user_id', $note->user_id)->get();
            $reminders = Reminder::where('user_id', $note->user_id)->get();
            
            return view('notes.edit', compact('note', 'categories', 'reminders'));
        } catch (\Exception $e) {
            throw $e; 
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        try {
            Gate::authorize('update-note', $note);

            $validatedData = $request->validate([
                'title' => 'required|string|min:5|max:255',
                'content' => 'required|string|min:10|max:1000',
                'category_id' => 'nullable|integer|exists:categories,id',
                'reminder_id' => 'nullable|integer|exists:reminders,id',
            ]);
    
            // 2. Cập nhật các thuộc tính của ghi chú
            $note->title = $validatedData['title'];
            $note->content = $validatedData['content'];
            $note->category_id = $validatedData['category_id'];
            $note->reminder_id = $validatedData['reminder_id'];
    
            $note->save(); 
    
            Alert::success('Success', 'Note has been updated successfully!');
         
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            throw $e; 
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        try {
            $note->delete();
    
            Alert::success('Success', 'Note deleted successfully!');
    
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            throw $e; 
        }   
    }

    public function getNotesByCategory(Request $request, $id) {//api
        $user = $request->user();
        if($id == 'all') {
            $notes = Note::where('user_id', $user->id)
                     ->with('category')
                     ->with('reminder')
                     ->get();
        } else {
             $notes = Note::where('user_id', $user->id)
                     ->where('category_id', $id)
                     ->with('category')
                     ->with('reminder')
                     ->get();
        }
        return response()->json($notes);
    }
}
