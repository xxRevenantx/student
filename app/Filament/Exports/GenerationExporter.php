<?php

namespace App\Filament\Exports;

use App\Models\Generation;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class GenerationExporter extends Exporter
{
    protected static ?string $model = Generation::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('order')
                ->label('ID'),
            ExportColumn::make('fecha_inicio'),
            ExportColumn::make('fecha_termino'),
            ExportColumn::make('status'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your generation export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
