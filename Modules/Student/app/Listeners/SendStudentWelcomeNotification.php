<?php

namespace Modules\Student\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Modules\Student\Events\StudentCreated;

/**
 * Class SendStudentWelcomeNotification
 *
 * Asynchronous event listener (queued via ShouldQueue) that handles 
 * dispatching welcome notifications upon new student registration.
 */
class SendStudentWelcomeNotification implements ShouldQueue
{
    /**
     * Create the event listener instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the queued event.
     *
     * @param StudentCreated $event
     * @return void
     */
    public function handle(StudentCreated $event): void
    {
        Log::info('Welcome notification sent (simulated)', [
            'student_id' => $event->student->id,
            'message'    => "Welcome to the school, {$event->student->name}!",
        ]);
    }
}