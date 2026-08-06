<?php

namespace Modules\Student\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Student\Events\StudentCreated;

/**
 * Class LogStudentCreation
 *
 * Handles the StudentCreated domain event by outputting structured detail to system log files.
 */
class LogStudentCreation
{
    /**
     * Create the event listener instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the student creation event.
     *
     * @param StudentCreated $event
     * @return void
     */
    public function handle(StudentCreated $event): void
    {
        Log::info('Student created', [
            'id'    => $event->student->id,
            'name'  => $event->student->name,
            'grade' => $event->student->grade,
        ]);
    }
}