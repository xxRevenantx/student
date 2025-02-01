<?php

namespace App\Filament\Exports;

use App\Models\Student;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StudentExporter extends Exporter
{
    protected static ?string $model = Student::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('curp'),
            ExportColumn::make('matricula'),
            ExportColumn::make('nombre'),
            ExportColumn::make('apellidoP'),
            ExportColumn::make('apellidoM'),
            ExportColumn::make('edad'),
            ExportColumn::make('fechaNacimiento'),
            ExportColumn::make('sexo'),
            ExportColumn::make('status'),
            ExportColumn::make('level_id'),
            ExportColumn::make('grade_id'),
            ExportColumn::make('group_id'),
            ExportColumn::make('generation_id'),
            ExportColumn::make('tutor_id'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your student export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
