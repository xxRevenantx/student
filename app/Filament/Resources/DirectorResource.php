<?php

namespace App\Filament\Resources;

use App\Filament\Exports\DirectorExporter;
use App\Filament\Resources\DirectorResource\Pages;
use App\Filament\Resources\DirectorResource\RelationManagers;
use App\Models\Director;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DirectorResource extends Resource
{
    protected static ?string $model = Director::class;

    protected static ?string $navigationIcon = 'icon-director';

    protected static ?string $modelLabel = 'Directores';

    protected static ?string $recordTitleAttribute = 'nombre';

    protected static int $globalSearchResultsLimit = 20;

    protected static ?string $navigationGroup = 'AUTORIDADES';







    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            TextInput::make('nombre')
                ->string()
                ->rules(['required'])
                ->label('Nombre del director')
                ->placeholder('Escribe el nombre del director'),
            TextInput::make('apellido_paterno')
                ->string()
                ->rules(['required'])
                ->label('Apellido Paterno')
                ->placeholder('Escribe el apellido paterno'),
            TextInput::make('apellido_materno')
                ->string()
                ->label('Apellido Materno')
                ->placeholder('Escribe el apellido materno')
                ->nullable(),
            TextInput::make('email')
                ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                ->validationMessages([
                    'unique' => 'El :attribute ya ha sido registrado. Intenta con otro',
                ])
                ->label('Correo Electrónico')
                ->placeholder('Escribe el correo electrónico')
                ->email()
                ->nullable(),
            TextInput::make('telefono')
                ->label('Teléfono')
                ->placeholder('Escribe el número de teléfono')
                ->tel()
                ->nullable(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(DirectorExporter::class)
                ->label('Exportar')
                ->icon('icon-excel')
        ])
            ->columns([

            TextColumn::make('order')
                ->label('Id')
                ->searchable()
                ->sortable(),

            TextColumn::make('nombre')
                ->label('Director')
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
                ->label('Correo Electrónico')
                ->searchable()
                ->sortable()
                  ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('telefono')
                ->label('Teléfono')
                ->searchable()
                ->sortable()
                  ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([


            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                ->modal(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                ExportBulkAction::make()
                ->exporter(DirectorExporter::class)
                ->label('Exportar seleccionados')
                ->icon('icon-excel')

            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageDirectors::route('/'),
        ];
    }
}
