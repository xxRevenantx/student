<?php

namespace App\Observers;
use App\Models\Supervisor;

class SupervisorObserver
{
    public function creating(Supervisor $supervisor): void
    {
        $supervisor->order = Supervisor::max('order') + 1;
    }

    public function deleted(Supervisor $supervisor)
    {
        // Actualizar los niveles
        Supervisor::where('order', '>', $supervisor->order)
            ->decrement('order');
    }




}
