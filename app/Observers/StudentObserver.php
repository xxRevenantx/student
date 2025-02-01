<?php

namespace App\Observers;

use App\Models\Student;

class StudentObserver
{
    public function creating(Student $student): void
    {
        $student->order = Student::max('order') + 1;
    }

    public function deleted(Student $student)
    {
        // Actualizar los niveles
        Student::where('order', '>', $student->order)
            ->decrement('order');
    }
}
