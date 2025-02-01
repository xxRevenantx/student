<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentResource\Pages;
use App\Filament\Resources\StudentResource\RelationManagers;
use App\Models\Student;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;

class StudentResource extends Resource
{
    protected static ?string $model = Student::class;

    protected static ?string $navigationIcon = 'icon-school';

    protected static ?string $modelLabel = 'Estudiantes';

    protected static ?string $navigationGroup = 'GESTIÓN ACADÉMICA';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()->schema([


                Forms\Components\TextInput::make('curp')
                    ->label('CURP')
                    ->rule(['required', 'max:18'])
                    ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                    ->placeholder('Ingrese la CURP del alumno')
                    ->reactive()
                    ->live(debounce: 500) // Wait 500ms before re-rendering the form.
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $curp = strtoupper($state);
                            $matricula = substr($curp, 0, 4);
                            $set('matricula', $matricula);
                        }
                    }),
                Forms\Components\TextInput::make('matricula')
                    ->label('Matrícula')
                    ->rule(['required'])
                    ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                    ->placeholder('Ingrese la matrícula del alumno')
                    ->readonly(),

                Forms\Components\TextInput::make('nombre')
                    ->label('Nombre')
                    ->rule('required')
                    ->placeholder('Ingrese el nombre del alumno'),
                Forms\Components\TextInput::make('apellidoP')
                    ->label('Apellido Paterno')
                    ->rule('required')
                    ->placeholder('Ingrese el apellido paterno del alumno'),
                Forms\Components\TextInput::make('apellidoM')
                    ->label('Apellido Materno')
                    ->rule('required')
                    ->placeholder('Ingrese el apellido materno del alumno'),

                    Forms\Components\DatePicker::make('fechaNacimiento')
                        ->label('Fecha de nacimiento')
                        ->rule('required')
                        ->placeholder('Ingrese la fecha de nacimiento del alumno')
                        ->reactive()
                        ->live(debounce: 500) // Wait 500ms before re-rendering the form.
                        ->afterStateUpdated(function ($state, callable $set) {
                            if ($state) {
                                $birthDate = \Carbon\Carbon::parse($state);
                                $age = $birthDate->age;
                                $set('edad', $age);
                            }
                        }),
                    Forms\Components\TextInput::make('edad')
                        ->label('Edad')
                        ->rule('required')
                        ->placeholder('Ingrese la edad del alumno')
                        ->readonly(),


                    Forms\Components\Select::make('sexo')
                        ->label('Sexo')
                        ->options([
                            'H' => 'Hombre',
                            'M' => 'Mujer',
                        ])
                        ->rule('required')
                        ->placeholder('Seleccione el sexo del alumno'),


                ])->columns(2) ,

                Section::make()->schema([

                Forms\Components\Select::make('level_id')
                    ->label('Nivel')
                    ->rule('required')
                    ->relationship('level', 'level')
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (callable $set, $state) {
                        $set('grupos', null);
                        if (!$state) {
                            $set('grade_id', null);
                        }
                    })
                    ->placeholder('Seleccione el nivel del alumno'),


                Forms\Components\Select::make('grade_id')
                    ->label('Grado')
                    ->rule('required')
                    ->options(
                    fn (Get $get): Collection => \App\Models\Grade::query()
                    ->where('level_id', $get('level_id'))
                    ->pluck('grado', 'id')
                     )
                     ->reactive()
                     ->preload()
                    //  ->afterStateUpdated(fn (callable $set, $state) => $set('grupos', $state))
                    ->placeholder('Seleccione el grado del alumno'),


                Section::make()->schema([


                    Forms\Components\Select::make('grupo')
                        ->label('Grupo')
                        ->rule('required')
                        ->options(
                            fn (Get $get): array => \App\Models\Grade::query()
                                ->where('id', $get('grade_id'))
                                ->pluck('grupos', 'grupos')
                                ->toArray()
                        )
                        ->reactive()
                        ->preload()
                        ->placeholder('Seleccione el grupo del alumno')
                        ->required(),


                    // Forms\Components\Select::make('grupos')
                    // ->label('Grupos')
                    // ->options(
                    //     \App\Models\Group::all()->pluck('grupo', 'grupo')->toArray()
                    // )
                    // ->multiple()
                    // ->preload()
                    // ->reactive()
                    // ->rules('required')
                    // ->required(),


                    Forms\Components\Select::make('generation_id')
                    // ->relationship('generation', 'fecha_inicio')
                    ->label('Fecha de inicio')
                    ->rule('required')
                    ->reactive()
                    ->options(
                        fn (Get $get): Collection => \App\Models\Generation::query()
                            ->where('id', \App\Models\Grade::where('id', $get('grade_id'))->value('generation_id'))
                            ->pluck('fecha_inicio', 'id')
                    )
                    ->preload(),

                    Forms\Components\Select::make('generation_id')
                    // ->relationship('generation', 'fecha_inicio')
                    ->label('Fecha de término')
                    ->rule('required')
                    ->reactive()
                    ->options(
                        fn (Get $get): Collection => \App\Models\Generation::query()
                            ->where('id', \App\Models\Grade::where('id', $get('grade_id'))->value('generation_id'))
                            ->pluck('fecha_termino', 'id')
                    )
                    ->preload()



                ])->columns(3),


                Section::make()
                // ->aside()
                ->schema([

                    Forms\Components\Select::make('tutor_id')
                        ->label('Tutor')
                        ->relationship('tutor', 'nombre', function ($query) {
                            $query->selectRaw("CONCAT(nombre, ' ', apellidoP, ' ', apellidoM) as nombre_completo, id");
                        })
                        ->getOptionLabelFromRecordUsing(fn ($record) => $record->nombre_completo)
                        ->placeholder('Seleccione el tutor del alumno'),


                Forms\Components\FileUpload::make('foto')
                    ->label('Foto')
                    ->directory('imagenes')
                    ->storeFileNamesIn('original_filename')
                    ->placeholder('Seleccione la foto del alumno'),

                    Toggle::make('status')
                    ->label('Status')
                    ->default(1),
                ])->columns(2),

                ])->columns(2),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('curp')
                    ->label('CURP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('matricula')
                    ->label('Matrícula')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('full_name')
                    ->label('Nombre Completo')
                    ->getStateUsing(function ($record) {
                        return "{$record->nombre} {$record->apellidoP} {$record->apellidoM}";
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('grupo')
                    ->label('Grupo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('edad')
                    ->label('Edad')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sexo')
                    ->label('Sexo')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('status')
                    ->label('Status')

                    ->sortable(),
            ])
            ->filters([

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
            'index' => Pages\ListStudents::route('/'),
            'create' => Pages\CreateStudent::route('/create'),
            'edit' => Pages\EditStudent::route('/{record}/edit'),
        ];
    }
}
