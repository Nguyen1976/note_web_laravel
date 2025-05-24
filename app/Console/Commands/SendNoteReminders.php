<?php

namespace App\Console\Commands;

use App\Models\Reminder; // Đảm bảo đã use model Reminder
use App\Mail\NoteReminderMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class SendNoteReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminders:send-notes';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kiểm tra và gửi email nhắc nhở cho các ghi chú đến hạn';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();

        // Lấy tất cả các reminders chưa được gửi và đã đến hạn
        $dueReminders = Reminder::with(['notes', 'notes.user'])
            ->where('reminder_at', '<=', $now)
            ->where('sent', false) // <<< SỬA Ở ĐÂY: Chỉ lấy những reminder có 'sent' là false
            ->get();

        if ($dueReminders->isEmpty()) {
            Log::info('Không có nhắc nhở nào đến hạn hoặc chưa được gửi.');
            return Command::SUCCESS;
        }

        foreach ($dueReminders as $reminder) {
            $allNotesForThisReminderSent = true; // Giả định tất cả note sẽ được gửi thành công

            foreach ($reminder->notes as $note) {
                if ($note->user) {
                    try {
                        Mail::to($note->user->email)->send(new NoteReminderMail($note));
                        Log::info("Đã gửi email nhắc nhở cho note '{$note->title}' đến {$note->user->email}.");
                    } catch (\Exception $e) {
                        $allNotesForThisReminderSent = false; // Nếu có lỗi, không đánh dấu là đã gửi
                        Log::error("Lỗi khi gửi email cho note '{$note->title}': " . $e->getMessage());
                    }
                } else {
                    Log::warning("Note ID {$note->id} không có user liên kết, bỏ qua.");
                }
            }

            if ($allNotesForThisReminderSent) {
                $reminder->sent = true; 
                $reminder->save();
                $this->info("Đã xử lý xong và đánh dấu đã gửi cho nhắc nhở ID: {$reminder->id}.");
            } else {
                Log::error("Có lỗi xảy ra khi gửi email cho một số note của nhắc nhở ID: {$reminder->id}. Nhắc nhở này sẽ được thử lại lần sau.");
            }
        }

        Log::info('Hoàn tất việc gửi nhắc nhở.');
        return Command::SUCCESS;
    }
}
