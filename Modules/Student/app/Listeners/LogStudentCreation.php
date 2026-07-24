<?php

namespace Modules\Student\Listeners;

use Modules\Student\Events\StudentCreated;
use Illuminate\Support\Facades\Log;

class LogStudentCreation
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
        Log::info('Student created', [
            'id' => $event->student->id,
            'name' => $event->student->name,
            'grade' => $event->student->grade,
        ]);
    }
}