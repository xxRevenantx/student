<?php

namespace App\Filament\Imports;

use App\Models\Preescolar;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class PreescolarImporter extends Importer
{
    protected static ?string $model = Preescolar::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('curp')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('matricula')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('nombre')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('apellidoP')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('apellidoM')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('edad')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('fechaNacimiento')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('sexo')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('foto')
                ->rules(['max:255']),
            ImportColumn::make('level_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('grade_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('group_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),

            ImportColumn::make('generation_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('tutor_id')
                ->numeric()
                ->rules(['integer']),
            ImportColumn::make('order')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Preescolar
    {
        // return Preescolar::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Preescolar();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Alumnos importados y completados ' . number_format($import->successful_rows) . ' ' . str('filas')->plural($import->successful_rows) . ' importados.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('filas')->plural($failedRowsCount) . ' no importadas.';
        }

        return $body;
    }
}
