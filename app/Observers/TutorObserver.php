<?php

namespace App\Observers;

use App\Models\Tutor;

class TutorObserver
{
    public function creating(Tutor $tutor): void
    {
        $tutor->order = Tutor::max('order') + 1;
    }

    public function deleted(Tutor $tutor)
    {
        // Actualizar los niveles
        Tutor::where('order', '>', $tutor->order)
            ->decrement('order');
    }

}
