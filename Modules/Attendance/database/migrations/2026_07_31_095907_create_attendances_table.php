<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();

        // Student whose attendance is being recorded.
        $table->foreignId('student_id')->constrained()->cascadeOnDelete();

        // Date for which attendance is recorded.
        $table->date('attendance_date');

        // Attendance status.
        $table->enum('status', ['Present', 'Absent', 'Late']);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
