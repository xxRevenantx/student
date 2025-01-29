<?php

namespace App\Filament\Resources\DirectorResource\Pages;

use App\Filament\Resources\DirectorResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageDirectors extends ManageRecords
{
    protected static string $resource = DirectorResource::class;


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
