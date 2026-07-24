<?php

namespace Modules\Student\Listeners;

use Modules\Student\Events\StudentCreated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendStudentWelcomeNotification implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StudentCreated $event): void
    {
        Log::info('Welcome notification sent (simulated)', [
            'student_id' => $event->student->id,
            'message' => "Welcome to the school, {$event->student->name}!",
        ]);
    }
}