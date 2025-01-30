<?php

namespace App\Observers;

use App\Models\Generation;

class GenerationObserver
{


    public function creating(Generation $generation): void
    {
        $generation->order = Generation::max('order') + 1;
    }


    public function deleted(Generation $generation)
    {
        // Actualizar los niveles
        Generation::where('order', '>', $generation->order)
            ->decrement('order');

    }

}
