<?php

namespace App\Observers;

use App\Models\Director;
use Filament\Notifications\Notification;

class DirectorObserver
{

    public function creating(Director $director): void
    {
        $director->order = Director::max('order') + 1;
    }

    public function deleted(Director $director)
    {
        // Actualizar los niveles
        Director::where('order', '>', $director->order)
            ->decrement('order');
    }


}
