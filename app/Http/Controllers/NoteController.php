<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Note;
use App\Models\Reminder;
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
        $reminders = Reminder::where('user_id', $user->id)->get();
        return view('notes.create', compact('categories', 'reminders'));
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
        return redirect()->route('dashboard')
                         ->with('success', 'Note created successfully!');
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
        $categories = Category::where('user_id', $note->user_id)->get();
        $reminders = Reminder::where('user_id', $note->user_id)->get();
        
        return view('notes.edit', compact('note', 'categories', 'reminders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        // 1. Validate dữ liệu đầu vào từ form
        $validatedData = $request->validate([
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'content' => 'required|string',
            'category_id' => 'nullable|integer|exists:categories,id',
            'reminder_id' => 'nullable|integer|exists:reminders,id',
        ]);

        // 2. Cập nhật các thuộc tính của ghi chú
        $note->title = $validatedData['title'];
        $note->content = $validatedData['content'];
        $note->category_id = $validatedData['category_id'];
        $note->reminder_id = $validatedData['reminder_id'];
        // user_id không cần cập nhật vì nó đã được gán khi tạo

        $note->save(); // Lưu các thay đổi

        // 3. Chuyển hướng người dùng với thông báo thành công
        // Có thể chuyển hướng đến trang chi tiết ghi chú hoặc danh sách
        return redirect()->route('dashboard')
                         ->with('success', 'Note has been updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        // 3. Chuyển hướng người dùng với thông báo thành công
        return redirect()->route('dashboard')
                         ->with('success', 'Note deleted successfully!');
    }
}
