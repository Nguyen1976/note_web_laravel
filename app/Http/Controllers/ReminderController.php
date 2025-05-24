<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $user = $request->user();
        $reminders = Reminder::where('user_id', $user->id)->get();
        return view('reminders.index', compact('reminders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reminders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'reminder_at' => 'required|date',
        ]);


        $reminder = new Reminder();
        $reminder->reminder_at = $validatedData['reminder_at'];
        $reminder->sent = false;
        $reminder->user_id = Auth::id();

        $reminder->save();
        return redirect()->route('reminders.index')
                         ->with('success', 'Reminder đã được tạo thành công!');
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
    public function edit(Reminder $reminder)
    {
        return view('reminders.edit', compact('reminder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
         // 1. Validate dữ liệu đầu vào từ form
         $validatedData = $request->validate([
            'reminder_at' => 'required|date',
        ]);

        // 2. Cập nhật các thuộc tính của ghi chú
        $reminder->reminder_at = $validatedData['reminder_at'];

        $reminder->save(); // Lưu các thay đổi
        return redirect()->route('reminders.index')
                         ->with('success', 'Reminder đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Reminder $reminder)
    {
        // 2. Xóa ghi chú
        $reminder->delete();

        // 3. Chuyển hướng người dùng với thông báo thành công
        return redirect()->route('reminders.index')
                         ->with('success', 'Reminder đã được xóa thành công!');
    }
}
