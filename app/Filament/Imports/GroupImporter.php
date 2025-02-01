<?php

namespace App\Filament\Imports;

use App\Models\Group;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class GroupImporter extends Importer
{
    protected static ?string $model = Group::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('grupo')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('order')
                ->requiredMapping()
                ->numeric()
                ->rules(['required', 'integer']),
        ];
    }

    public function resolveRecord(): ?Group
    {
        // return Group::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Group();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your group import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
