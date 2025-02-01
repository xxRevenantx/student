<?php

namespace App\Observers;
use App\Models\Grade;

class GradeObserver
{

    public function creating(Grade $grade): void
    {
        $grade->order = Grade::max('order') + 1;
    }


    public function deleted(Grade $grade)
    {
        // Actualizar los niveles
        Grade::where('order', '>', $grade->order)
            ->decrement('order');

    }
}
