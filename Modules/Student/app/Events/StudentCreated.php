<?php

namespace Modules\Student\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Modules\Student\Models\Student;

/**
 * Class StudentCreated
 *
 * Domain event dispatched when a new student record is saved.
 * Implements ShouldBroadcast to stream WebSocket notifications via Laravel Reverb.
 */
class StudentCreated implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    /**
     * Create a new event instance with PHP 8 constructor property promotion.
     *
     * @param Student $student Newly created student model
     */
    public function __construct(
        public Student $student
    ) {}

    /**
     * Define the public WebSocket channel for broadcast.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('students'),
        ];
    }

    /**
     * Define the custom event alias listened to by Laravel Echo on the frontend.
     *
     * @return string
     */
    public function broadcastAs(): string
    {
        return 'student.created';
    }

    /**
     * Define the customized payload sent over the WebSocket connection.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return [
            'name' => $this->student->name,
        ];
    }
}