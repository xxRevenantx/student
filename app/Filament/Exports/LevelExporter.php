<?php

namespace App\Filament\Exports;

use App\Models\Level;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class LevelExporter extends Exporter
{
    protected static ?string $model = Level::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('level')->label("Nivel"),
            ExportColumn::make('slug')->label("Ruta"),
            ExportColumn::make('imagen')->label("Logo"),
            ExportColumn::make('color')->label("Color"),
            ExportColumn::make('cct')->label("CCT"),
            ExportColumn::make('director.nombre')->label("Director"),
            ExportColumn::make('supervisor.nombre')->label("Supervisor"),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'El nivel ha sido exportado y completado ' . number_format($export->successful_rows) . ' ' . str('filas')->plural($export->successful_rows) . ' exportadas.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
