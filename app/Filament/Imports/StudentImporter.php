<?php

namespace App\Filament\Imports;

use App\Models\Student;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StudentImporter extends Importer
{
    protected static ?string $model = Student::class;

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
                ->rules(['required']),
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
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Student
    {
        // return Student::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Student();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your student import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
