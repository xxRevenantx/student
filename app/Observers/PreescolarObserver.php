<?php

namespace App\Observers;

use App\Models\Preescolar;

class PreescolarObserver
{
    public function creating(Preescolar $preeescolar): void
    {
        $preeescolar->order = Preescolar::max('order') + 1;
    }

    public function deleted(Preescolar $preeescolar)
    {
        // Actualizar los preescolares que tengan un order mayor al preescolar eliminado
        Preescolar::where('order', '>', $preeescolar->order)
            ->decrement('order');
    }
}
