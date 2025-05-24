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
                         ->with('success', 'Reminder created successfully!');
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
         $validatedData = $request->validate([
            'reminder_at' => 'required|date',
        ]);

        $reminder->reminder_at = $validatedData['reminder_at'];

        $reminder->save(); 
        return redirect()->route('reminders.index')
                         ->with('success', 'Reminder has been updated successfully.!');
    }

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Reminder $reminder)
    {
        $reminder->delete();

        return redirect()->route('reminders.index')
                         ->with('success', 'Reminder has been deleted successfully.!');
    }
}
