<?php

namespace App\Filament\Imports;

use App\Models\Generation;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class GenerationImporter extends Importer
{
    protected static ?string $model = Generation::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('fecha_inicio')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('fecha_termino')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('status')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('level_id')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
            ImportColumn::make('order')
                ->numeric()
                ->rules(['integer']),
        ];
    }

    public function resolveRecord(): ?Generation
    {
        // return Generation::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Generation();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Las generaciones han sido importadas y completadas ' . number_format($import->successful_rows) . ' ' . str('filas')->plural($import->successful_rows) . ' importadas.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
