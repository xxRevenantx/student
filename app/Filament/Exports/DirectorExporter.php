<?php

namespace App\Filament\Exports;

use App\Models\Director;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class DirectorExporter extends Exporter
{
    protected static ?string $model = Director::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('nombre'),
            ExportColumn::make('apellido_paterno'),
            ExportColumn::make('apellido_materno'),
            ExportColumn::make('email'),
            ExportColumn::make('telefono'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Director(es) exportado(s) exitosamente ' . number_format($export->successful_rows) . ' ' . str('fila(s)')->plural($export->successful_rows) . ' exportada(s).';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }





}
