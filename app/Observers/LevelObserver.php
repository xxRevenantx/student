<?php

namespace App\Observers;

use App\Models\Level;
use Illuminate\Support\Facades\Storage;

class LevelObserver
{

    public function creating(Level $level): void
    {
        $level->order = Level::max('order') + 1;
    }


    public function deleting(Level $level): void // Antes de eliminar un nivel, eliminamos la imagen asociada a ese post si la tiene en la carpeta posts y en la tabla images
    {

        if ($level->imagen) {
            Storage::delete($level->imagen);
        }
    }


    public function deleted(Level $level)
    {
        // Actualizar los niveles
        Level::where('order', '>', $level->order)
            ->decrement('order');

    }

    // public function updated(Level $level){
    //     if ($level->imagen) {
    //         Storage::delete($level->imagen);
    //     }
    // }




}
