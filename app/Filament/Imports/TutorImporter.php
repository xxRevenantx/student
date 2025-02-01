<?php

namespace App\Filament\Imports;

use App\Models\Tutor;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class TutorImporter extends Importer
{
    protected static ?string $model = Tutor::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('curp'),
            ImportColumn::make('nombre'),
            ImportColumn::make('apellidoP'),
            ImportColumn::make('apellidoM'),
            ImportColumn::make('calle'),
            ImportColumn::make('exterior'),
            ImportColumn::make('interior'),
            ImportColumn::make('localidad'),
            ImportColumn::make('colonia'),
            ImportColumn::make('cp'),
            ImportColumn::make('municipio'),
            ImportColumn::make('estado'),
            ImportColumn::make('telefono'),
            ImportColumn::make('celular'),
            ImportColumn::make('email'),
            ImportColumn::make('parentesco'),
            ImportColumn::make('ocupacion'),
            ImportColumn::make('order'),
        ];
    }

    public function resolveRecord(): ?Tutor
    {
        // return Tutor::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Tutor();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your tutor import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
