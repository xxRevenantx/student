<?php

namespace App\Filament\Exports;

use App\Models\Tutor;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class TutorExporter extends Exporter
{
    protected static ?string $model = Tutor::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('curp'),
            ExportColumn::make('nombre'),
            ExportColumn::make('apellidoP'),
            ExportColumn::make('apellidoM'),
            ExportColumn::make('calle'),
            ExportColumn::make('exterior'),
            ExportColumn::make('interior'),
            ExportColumn::make('localidad'),
            ExportColumn::make('colonia'),
            ExportColumn::make('cp'),
            ExportColumn::make('municipio'),
            ExportColumn::make('estado'),
            ExportColumn::make('telefono'),
            ExportColumn::make('celular'),
            ExportColumn::make('email'),
            ExportColumn::make('parentesco'),
            ExportColumn::make('ocupacion'),
            ExportColumn::make('order'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your tutor export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
