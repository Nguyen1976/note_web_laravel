<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NoteController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReminderController;
use App\Models\Note;
use Illuminate\Console\View\Components\Alert;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert as FacadesAlert;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::get('/dashboard/category/{id}', [DashboardController::class, 'filterByCategory'])
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard.category');


Route::middleware('auth', 'verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('categories', CategoryController::class);
    Route::resource('notes', NoteController::class);
    Route::resource('reminders', ReminderController::class);

    // api
    Route::get('/notes/category/{id}', [NoteController::class, 'getNotesByCategory']);
});

//Begin: send email while login
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // Xác minh thành công
    return redirect('/dashboard'); // Điều hướng sau khi xác minh
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Đã gửi lại email xác minh!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');//Giới hạn 6 lượt gửi mỗi phút
//End
require __DIR__.'/auth.php';



//Test xử lý lỗi tập trung
Route::get('/test-model-not-found', function () {
    try {
        $note = Note::findOrFail(999999); 
        return "Tìm thấy ghi chú: " . $note->title;
    } catch (\Exception $e) {
        throw $e; 
    }
});
