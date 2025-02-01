<?php

namespace App\Observers;

use App\Models\Group;

class GroupObserver
{
    public function creating(Group $group): void
    {
        $group->order = Group::max('order') + 1;
    }

    public function deleted(Group $group)
    {
        // Actualizar los niveles
        Group::where('order', '>', $group->order)
            ->decrement('order');

    }
}
