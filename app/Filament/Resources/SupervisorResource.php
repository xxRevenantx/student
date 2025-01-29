<?php

namespace App\Filament\Resources;

use App\Filament\Exports\SupervisorExporter;
use App\Filament\Resources\SupervisorResource\Pages;
use App\Filament\Resources\SupervisorResource\RelationManagers;
use App\Models\Supervisor;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Enums\FiltersLayout;



class SupervisorResource extends Resource
{
    protected static ?string $model = Supervisor::class;

    protected static ?string $navigationIcon = 'icon-supervisor';

    protected static ?string $modelLabel = 'Supervisores';

    protected static ?string $navigationGroup = 'Autoridades';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nombre')->placeholder('Nombre')
                    ->rules('required')
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_paterno')->placeholder('Apellido Paterno')
                    ->rules('required')
                    ->maxLength(255),
                Forms\Components\TextInput::make('apellido_materno')->placeholder('Apellido Materno')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')->placeholder('Email')
                    ->nullable()
                    ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                    ->maxLength(255),
                Forms\Components\TextInput::make('telefono')->placeholder('Telefono')
                    ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('zona')->placeholder('Zona')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sector')->placeholder('Sector')
                      ->nullable()
                    ->maxLength(255),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(SupervisorExporter::class)
                ->label('Exportar')
                ->icon('icon-excel')
        ])

            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('apellido_paterno')
                    ->label('Apellido Paterno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('apellido_materno')
                    ->label('Apellido Materno')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('telefono')
                    ->label('Telefono')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('zona')
                    ->label('Zona')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('sector')
                    ->label('Sector')
                    ->searchable()
                    ->sortable(),



            ])
            ->filters([


            ],  layout: FiltersLayout::AboveContent)

            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
                ->exporter(SupervisorExporter::class)
                ->label('Exportar seleccionados')
                ->icon('icon-excel')
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSupervisors::route('/'),
        ];
    }
}
