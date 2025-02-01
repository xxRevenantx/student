<?php

namespace App\Filament\Resources;

use App\Filament\Exports\TutorExporter;
use App\Filament\Imports\TutorImporter;
use App\Filament\Resources\TutorResource\Pages;
use App\Filament\Resources\TutorResource\RelationManagers;
use App\Models\Tutor;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TutorResource extends Resource
{
    protected static ?string $model = Tutor::class;


    protected static ?string $navigationIcon = 'icon-tutor';

    protected static ?string $modelLabel = 'Tutores';

    protected static ?string $navigationGroup = 'GESTIÓN ACADÉMICA';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                Forms\Components\TextInput::make('curp')
                    ->label('CURP')
                    ->rule(['required',  'max:18'])
                    ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                    ->placeholder('Ingrese la CURP del tutor'),
                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->rule('required')
                    ->placeholder('Ingrese el nombre del tutor'),
                Forms\Components\TextInput::make('apellidoP')
                    ->label('Apellido Paterno')
                    ->rule('required')
                    ->placeholder('Ingrese el apellido paterno del tutor'),
                Forms\Components\TextInput::make('apellidoM')
                    ->label('Apellido Materno')
                    ->rule('required')
                    ->placeholder('Ingrese el apellido materno del tutor'),
                Forms\Components\TextInput::make('calle')
                    ->label('Calle')
                    ->placeholder('Ingrese la calle del tutor'),
                Forms\Components\TextInput::make('exterior')
                    ->label('Número Exterior')
                    ->placeholder('Ingrese el número exterior del tutor'),
                Forms\Components\TextInput::make('interior')
                    ->label('Número Interior')
                    ->placeholder('Ingrese el número interior del tutor'),
                Forms\Components\TextInput::make('localidad')
                    ->label('Localidad')
                    ->placeholder('Ingrese la localidad del tutor'),
                Forms\Components\TextInput::make('colonia')
                    ->label('Colonia')
                    ->placeholder('Ingrese la colonia del tutor'),
                Forms\Components\TextInput::make('cp')
                    ->label('Código Postal')
                    ->placeholder('Ingrese el código postal del tutor'),
                Forms\Components\TextInput::make('municipio')
                    ->label('Municipio')
                    ->placeholder('Ingrese el municipio del tutor'),
                Forms\Components\TextInput::make('estado')
                    ->label('Estado')
                    ->placeholder('Ingrese el estado del tutor'),
                Forms\Components\TextInput::make('telefono')
                    ->label('Teléfono')
                    ->placeholder('Ingrese el teléfono del tutor'),
                Forms\Components\TextInput::make('celular')
                    ->label('Celular')
                    ->placeholder('Ingrese el celular del tutor'),
                Forms\Components\TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->placeholder('Ingrese el correo electrónico del tutor'),
                Forms\Components\TextInput::make('parentesco')

                    ->label('Parentesco')
                    ->placeholder('Ingrese el parentesco del tutor'),
                Forms\Components\TextInput::make('ocupacion')
                    ->label('Ocupación')
                    ->placeholder('Ingrese la ocupación del tutor'),

                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

        ->reorderable('order')
        ->headerActions([
            ImportAction::make()
                ->importer(TutorImporter::class)
                ->icon('icon-excel')
                ->label('Importar Grados')
                ,
            ExportAction::make()
                ->exporter(TutorExporter::class)
                ->icon('icon-excel')
        ])


            ->columns([
                Tables\Columns\TextColumn::make('curp')
                    ->label('CURP')
                    ->badge()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('apellidoP')
                    ->label('Apellido Paterno')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('apellidoM')
                    ->label('Apellido Materno')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parentesco')
                    ->badge()
                    ->label('Parentesco')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('ocupacion')
                    ->label('Ocupación')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTutors::route('/'),
            'create' => Pages\CreateTutor::route('/create'),
            'edit' => Pages\EditTutor::route('/{record}/edit'),
        ];
    }
}
