<?php

namespace App\Filament\Resources;

use App\Filament\Imports\PreescolarImporter;
use App\Filament\Resources\PreescolarResource\Pages;
use App\Filament\Resources\PreescolarResource\RelationManagers;
use App\Models\Preescolar;
use App\Models\Student;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;

class PreescolarResource extends Resource
{
    protected static ?string $model = Preescolar::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $modelLabel = 'Preescolar';

    protected static ?string $navigationLabel = 'Preescolar';

    protected static ?string $navigationBadgeTooltip = 'Número de alumnos';

    protected static ?string $pluralModelLabel = 'Alumnos de preescolar';

    protected static ?string $singularModelLabel = 'Alumno de preescolar';

    protected static ?string $recordTitleAttribute = 'matricula';




    protected static ?string $navigationGroup = 'GESTIÓN ACADÉMICA';

    protected static ?int $navigationSort = 3;


    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                    DateTimePicker::make('created_at')
                        ->label('Fecha de registro')
                        ->default(now()),



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
    
                    // Forms\Components\Select::make('level_id')
                    //     ->label('Nivel')
                    //     ->rule('required')
                    //     ->relationship('level', 'level')
                    //     ->preload()
                    //     ->live()
                    //     ->afterStateUpdated(function (callable $set, $state) {
                    //         $set('grupos', null);
                    //         if (!$state) {
                    //             $set('grade_id', null);
                    //         }
                    //     })
                    //     ->placeholder('Seleccione el nivel del alumno'),
                    Forms\Components\Select::make('level_id')
                        ->label('Preescolar')
                        ->relationship('level', 'level', function ($query) {
                            $query->where('id', 1);
                        })
                        ->live()
                        ->preload(),
    
    
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
    
                        Forms\Components\Select::make('group_id')
                        ->label('Grupo')
                        ->rule('required')
                        ->rule('required')
                        ->options([
                            '1' => 'A',
                            '2' => 'B',
                            '3' => 'C',
                            '4' => 'D',
                            '5' => 'E',
                            ]
                         )
                         ->reactive()
                         ->preload()
                        ->placeholder('Seleccione el grupo del alumno')
                        ->required(),
                        
                        

    
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

        ->reorderable('order')
        ->headerActions([
        
            CreateAction::make('calificaciones')
            ->label('Calificaciones') // Cambia el texto del botón "Crear"
            ->color('info') // Opcional: Cambia el color del botón
            ->icon('heroicon-o-plus'), // Opcional: Agrega un icono




            CreateAction::make()
            ->label('Nuevo alumno') // Cambia el texto del botón "Crear"
            ->color('primary') // Opcional: Cambia el color del botón
            ->icon('heroicon-o-plus'), // Opcional: Agrega un icono



    
            ImportAction::make()
                ->importer(PreescolarImporter::class)
                ->icon('icon-excel')
                ->label('Importar Estudiantes'),
        ])






            ->columns([

                TextColumn::make('order' ,'#')
                ->sortable()
                ->searchable(),


                ImageColumn::make('foto', 'foto')->circular(),

                Tables\Columns\TextColumn::make('matricula')
                ->label('Matrícula')
                ->badge()
                ->color('success')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('curp')
                    ->label('CURP')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nombre')
                    ->label('Nombre Completo')
                    ->getStateUsing(function ($record) {
                        return "{$record->nombre} {$record->apellidoP} {$record->apellidoM}";
                    })
                    ->hidden()
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('level.level')
                    ->label('Nivel')
                    ->searchable()
                    ->alignCenter()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('grade.grado_numero')
                    ->label('Grado')
                    ->searchable()
                    ->alignCenter()
                    ->sortable(),
                

                Tables\Columns\TextColumn::make('group.grupo')
                    ->label('Grupo')
                    ->searchable()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('edad')
                    ->label('Edad')
                    ->searchable()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sexo')
                    ->label('Sexo')
                    ->searchable()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('status')
                ->alignCenter()
                    ->label('Status')
                    ->sortable(),

                ])
            ->filters([
                SelectFilter::make('level_id')
                ->label('Nivel')
                ->options(
                    fn (Get $get): Collection => \App\Models\Level::query()
                        ->where('id', 1)
                        ->pluck('level', 'id')
                )
                ->preload()
                ->default(1),

                SelectFilter::make('grade_id')
                ->label('Grado')
                ->preload()
                ->relationship('grade', 'grado_numero', function ($query) {
                    $query->where('level_id', 1);
                }),

                SelectFilter::make('group_id')
                ->label('Grupo')
                ->preload()
                ->options(
                    fn (Get $get): Collection => \App\Models\Group::query()
                        ->pluck('grupo', 'id')
                ),

                SelectFilter::make('edad')
                ->label('Edad')
                ->options([
                    '2' => '2 años',
                    '3' => '3 años',
                    '4' => '4 años',
                    '5' => '5 años',
                    '6' => '6 años',
                ])
                ->preload(),

                




                ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()


                ,
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
            'index' => Pages\ListPreescolars::route('/'),
            'create' => Pages\CreatePreescolar::route('/create'),
            'edit' => Pages\EditPreescolar::route('/{record}/edit'),
        ];
    }
}
