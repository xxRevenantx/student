<?php

namespace App\Filament\Resources\PreescolarResource\Pages;

use App\Filament\Resources\PreescolarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPreescolar extends EditRecord
{
    protected static string $resource = PreescolarResource::class;


    
    public function getTitle(): string
    {
        return 'Modificar Alumno'; // Cambia el título aquí
    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
