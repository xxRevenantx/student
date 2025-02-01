<?php

namespace App\Filament\Resources;


use App\Filament\Exports\GroupExporter;
use App\Filament\Imports\GroupImporter;
use App\Filament\Resources\GroupResource\Pages;
use App\Filament\Resources\GroupResource\RelationManagers;
use App\Models\Group;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Filament\Tables\View\TablesRenderHook;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupResource extends Resource
{
    protected static ?string $model = Group::class;

    protected static ?string $navigationIcon = 'icon-group';


    protected static ?string $modelLabel = 'Grupos';

    protected static ?string $navigationGroup = 'ESTRUCTURA ACADÉMICA';

    protected static ?int $navigationSort = 2;



    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('grupo')
                    ->placeholder('Nombre del grupo')
                    ->label('Grupo')
                    ->rules('required|string|unique:groups,grupo|regex:/^[A-Z]+$/') // Asegurarse de que sea texto, único y solo letras de la A a la Z
                    ->unique(ignoreRecord: true) // Ignorar el campo si ya ha sido registrado
                    ->afterStateUpdated(fn ($state, callable $set) => $set('grupo', strtoupper($state))) // Convertir a mayúsculas
                    ->maxLength(1) // Limitar la longitud máxima del texto
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->reorderable('order')
        ->headerActions([
            ImportAction::make()
                ->importer(GroupImporter::class)
                ->icon('icon-excel')
                ->label('Importar Grupos')
                ,
            ExportAction::make()
                ->exporter(GroupExporter::class)
                ->icon('icon-excel')
                ->label('Exportar Grupos'),
        ])
            ->columns([

                Tables\Columns\TextColumn::make('grupo')
                    ->label('Grupo')
                    ->searchable()
                    ->sortable(),


            ])->defaultSort('order')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ManageGroups::route('/'),
        ];
    }
}
