<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add foreign key columns to students.
     *
     * Why?
     * We keep the existing 'grade' and 'subject' text columns for now
     * and gradually migrate to proper relationships.
     */
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {

            // Links a student to a grade.
            $table->foreignId('grade_id')
                ->nullable()
                ->constrained('grades')
                ->nullOnDelete();

            // Links a student to a subject.
            $table->foreignId('subject_id')
                ->nullable()
                ->constrained('subjects')
                ->nullOnDelete();

        });
    }

    /**
     * Remove the foreign key columns.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {

            $table->dropForeign(['grade_id']);
            $table->dropForeign(['subject_id']);

            $table->dropColumn([
                'grade_id',
                'subject_id',
            ]);

        });
    }
};