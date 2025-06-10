<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ReminderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        try {
            $user = $request->user();
            $reminders = Reminder::where('user_id', $user->id)->get();
            return view('reminders.index', compact('reminders'));
        } catch (\Exception $e) {
            throw $e; 
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //Get note by user
        $user = $request->user();

        $notes = $user->notes()->with('category')->get();
        return view('reminders.create', [
            'notes' => $notes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'reminder_at' => 'required|date',
                 'note_id' => 'nullable|array',
                 'note_id.*' => 'exists:notes,id',
            ]);
    
    
            $reminder = new Reminder();
            $reminder->reminder_at = $validatedData['reminder_at'];
            $reminder->sent = false;
            $reminder->user_id = Auth::id();
    
            $reminder->save();

            if (!empty($validatedData['note_id'])) {
                foreach ($validatedData['note_id'] as $noteId) {
                    $note = Note::find($noteId);
                    if ($note) {
                        $note->reminder_id = $reminder->id;
                        $note->save();
                    }
                }
            }
    
            Alert::success('Success', 'Reminder created successfully!');
            return redirect()->route('reminders.index');
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
    public function edit(Request $request, Reminder $reminder)
    {
        $user = $request->user();

        $notes = $user->notes()->with('category')->get();
        return view('reminders.edit', compact('reminder', 'notes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reminder $reminder)
    {
        try {
            $validatedData = $request->validate([
                'reminder_at' => 'required|date',
                'note_id' => 'nullable|array',
                'note_id.*' => 'exists:notes,id',
                'sent' => 'nullable|boolean'
            ]);
    
           $reminder->reminder_at = $validatedData['reminder_at'];

            $reminder->sent = $request->has('sent');

           if (!empty($validatedData['note_id'])) {
                foreach ($validatedData['note_id'] as $noteId) {
                    $note = Note::find($noteId);
                    if ($note) {
                        $note->reminder_id = $reminder->id;
                        $note->save();
                    }
                }
            }
    
           $reminder->save(); 

    
           Alert::success('Success', 'Reminder updated successfully!');
           return redirect()->route('reminders.index');
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reminder $reminder)
    {
        try {
            $reminder->delete();
    
            Alert::success('Success', 'Reminder deleted successfully!');
    
            return redirect()->route('reminders.index');
        } catch (\Exception $e) {
            throw $e; 
        }
    }
}
