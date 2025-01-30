<?php

namespace App\Filament\Resources;

use App\Filament\Exports\GenerationExporter;
use App\Filament\Imports\GenerationImporter;
use App\Filament\Resources\GenerationResource\Pages;
use App\Filament\Resources\GenerationResource\RelationManagers;
use App\Models\Generation;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Filters\Layout;

class GenerationResource extends Resource
{
    protected static ?string $model = Generation::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Generaciones';

    protected static ?string $navigationGroup = 'ACADÉMICA';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Forms\Components\TextInput::make('fecha_inicio')->placeholder('Fecha de inicio')
                ->label('Fecha de inicio')
                ->numeric()
                ->rules('required')
                ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                ->maxLength(4)
                ->minValue(2000)
                ->maxValue(3000)


                ,

                Forms\Components\TextInput::make('fecha_termino')->placeholder('Fecha de término')
                ->label('Fecha de término')
                ->numeric()
                ->rules('required')
                ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                ->maxLength(4)
                ->minValue(2000)
                ->maxValue(3000)
                ,




                Toggle::make('status')
                ->label('Status')
                ->default(1),

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->reorderable('order')
        ->headerActions([
            ImportAction::make()
                ->importer(GenerationImporter::class)
                ->icon('icon-excel'),
            ExportAction::make()
                ->exporter(GenerationExporter::class)
                ->icon('icon-excel')
                ->label('Exportar Generaciones'),
        ])
            ->columns([

                Tables\Columns\TextColumn::make('order')
                    ->searchable()
                    ->sortable()
                    ->label('ID'),

                Tables\Columns\TextColumn::make('fecha_inicio')
                    ->searchable()
                    ->sortable()
                    ->label('Fecha de inicio'),
                Tables\Columns\TextColumn::make('fecha_termino')
                    ->searchable()
                    ->sortable()
                    ->label('Fecha de término')
                    ,
                    ToggleColumn::make('status')
                    ,

            ])->defaultSort('order')
            ->filters([
                //
            ],  layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageGenerations::route('/'),
        ];
    }
}
