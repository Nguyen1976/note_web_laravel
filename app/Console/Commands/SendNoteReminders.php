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
        protected $description = 'Kiểm tra và gửi email nhắc nhở (tổng hợp cho user của reminder) đến hạn';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Log::info('SendNoteReminders Command: Bắt đầu thực thi.');
        $now = Carbon::now();

        $dueReminders = Reminder::with([
            'user',
            'notes.category' // Tải các notes và category của từng note
        ])->where('reminder_at', '<=', $now)
            ->where('sent', false)
            ->get();

        if ($dueReminders->isEmpty()) {
            return Command::SUCCESS;
        }

        foreach ($dueReminders as $reminder) {
            Log::info("SendNoteReminders Command: Đang xử lý Reminder ID: {$reminder->id} cho User ID: {$reminder->user->id} (Thời gian nhắc: {$reminder->reminder_at->toDateTimeString()})");

            // User nhận mail chính là $reminder->user
            $userToSendTo = $reminder->user;

            // Tất cả các notes của reminder này (đã có category)
            $allNotesForThisReminder = $reminder->notes;

            if ($allNotesForThisReminder->isEmpty()) {
                Log::info("SendNoteReminders Command: Reminder ID {$reminder->id} không có notes nào để gửi cho User ID {$userToSendTo->id}. Đánh dấu là đã xử lý.");
                $reminder->save();
                continue; // Chuyển sang reminder tiếp theo
            }

            $emailSentSuccessfully = true;
            try {
                Mail::to($userToSendTo->email)->send(new NoteReminderMail($userToSendTo, $allNotesForThisReminder, $reminder));
            } catch (\Exception $e) {
                $emailSentSuccessfully = false;
            }

            if ($emailSentSuccessfully) {
                $reminder->sent = true; // Đánh dấu là đã gửi email thành công
                $reminder->save();
            } else {
                Log::error("SendNoteReminders Command: Có lỗi xảy ra khi gửi email cho Reminder ID: {$reminder->id}. Nhắc nhở này sẽ được thử lại lần sau.");
            }
        }

        Log::info('SendNoteReminders Command: Hoàn tất việc kiểm tra và gửi nhắc nhở.');
        return Command::SUCCESS;
    }
}
