<?php
namespace App\Console\Commands;

use App\Mail\DueDateReminderMail;
use App\Mail\OverdueReminderMail;
use App\Models\Borrow;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendBookReminders extends Command {
    protected $signature   = 'librowse:send-reminders';
    protected $description = 'Send due date and overdue reminders to borrowers';

    public function handle() {
        // Due tomorrow reminders
        $dueTomorrow = Borrow::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->whereDate('due_date', now()->addDay())
            ->get();

        foreach ($dueTomorrow as $borrow) {
            Mail::to($borrow->user->email)
                ->send(new DueDateReminderMail($borrow));
            $this->info('Due reminder sent to: '.$borrow->user->email);
        }

        // Overdue reminders
        $overdue = Borrow::with(['user', 'book'])
            ->where('status', 'borrowed')
            ->whereDate('due_date', '<', now())
            ->get();

        foreach ($overdue as $borrow) {
            $borrow->update(['status' => 'overdue']);
            Mail::to($borrow->user->email)
                ->send(new OverdueReminderMail($borrow));
            $this->info('Overdue reminder sent to: '.$borrow->user->email);
        }

        $this->info('All reminders sent!');
    }
}