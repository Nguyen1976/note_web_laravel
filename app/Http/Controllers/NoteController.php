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
    public function edit(Note $note)
    {
        if ($note->user_id !== Auth::id()) {
            // abort(403, 'Bạn không có quyền chỉnh sửa ghi chú này.');
            // Hoặc chuyển hướng với thông báo lỗi
            return redirect()->route('dasboard')->with('error', 'Bạn không có quyền chỉnh sửa ghi chú này.');
        }

        $categories = Category::where('user_id', $note->user_id)->get();
        
        return view('notes.edit', compact('note', 'categories'));
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
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        // 2. Cập nhật các thuộc tính của ghi chú
        $note->title = $validatedData['title'];
        $note->content = $validatedData['content'];
        $note->category_id = $validatedData['category_id'];
        // user_id không cần cập nhật vì nó đã được gán khi tạo

        $note->save(); // Lưu các thay đổi

        // 3. Chuyển hướng người dùng với thông báo thành công
        // Có thể chuyển hướng đến trang chi tiết ghi chú hoặc danh sách
        return redirect()->route('dashboard')
                         ->with('success', 'Ghi chú đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
         if ($note->user_id !== Auth::id()) {
            return redirect()->route('dashboard')
                             ->with('error', 'Bạn không có quyền xóa ghi chú này.');
        }

        // 2. Xóa ghi chú
        $note->delete();

        // 3. Chuyển hướng người dùng với thông báo thành công
        return redirect()->route('dashboard')
                         ->with('success', 'Ghi chú đã được xóa thành công!');
    }
}
