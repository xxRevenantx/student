<?php

namespace App\Filament\Resources;

use App\Filament\Exports\GradeExporter;
use App\Filament\Imports\GradeImporter;
use App\Filament\Resources\GradeResource\Pages;
use App\Filament\Resources\GradeResource\RelationManagers;
use App\Filament\Resources\GradeResource\RelationManagers\GroupsRelationManager;
use App\Models\Grade;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Collection;
use Filament\Forms\Components\TagsInput;


class GradeResource extends Resource
{
    protected static ?string $model = Grade::class;

    protected static ?string $navigationIcon = 'icon-grade';

    protected static ?string $modelLabel = 'Grados';

    protected static ?string $navigationGroup = 'ESTRUCTURA ACADÉMICA';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                Section::make()->schema([

                    Forms\Components\TextInput::make('grado')
                    ->placeholder('Nombre del grado')
                    ->label('Nombre')
                    ->rules('required')
                    ->required(),
                Forms\Components\TextInput::make('grado_numero')
                    ->placeholder('Número del grado')
                    ->label('Grado')
                    ->rules('required')
                    ->minValue(1)
                    ->maxValue(10)
                    ->numeric()
                    ->required(),


                    Select::make('grupos')
                        ->label('Grupos')
                        ->placeholder('Agrega los grupos')
                        ->options(
                            \App\Models\Group::all()->pluck('grupo', 'grupo')->toArray()
                        )
                        ->multiple()
                        ->preload()
                        ->reactive()
                        ->rules('required')
                        ->required(),


                ])->columns(3),


                Forms\Components\Select::make('level_id')
                    ->relationship('level', 'level')
                    ->label('Nivel')
                    ->preload()
                    ->live()
                    ->rules('required')
                    ->required(),

                Forms\Components\Select::make('generation_id')
                   ->options(
                    fn (Get $get): Collection => \App\Models\Generation::query()
                    ->where('level_id', $get('level_id'))
                    ->where('status', 1)
                    ->pluck('fecha_inicio', 'id')
                     )
                     ->reactive()
                     ->afterStateUpdated(fn (callable $set, $state) => $set('generation_id', $state))
                     ->rule('required')
                     ->validationAttribute('generation_id')
                     ->validationMessages([
                        'unique' => 'La fecha ya ha sido registrada para este nivel',
                    ])
                    ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO

                    //  ->disabled(fn (Get $get) => \App\Models\Grade::query()->where('generation_id', $get('generation_id'))->exists() ? true : false)
                    ->label('Fecha de inicio')
                    ->preload()
                    ->required(),


                    Forms\Components\Select::make('generation_id')
                    ->options(
                        fn (Get $get): Collection => \App\Models\Generation::query()
                        ->where('level_id', $get('level_id'))
                        ->where('status', 1)
                        ->pluck('fecha_termino', 'id')
                         )
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set, $state) => $set('generation_id', $state))
                    ->rule('required')
                    ->validationAttribute('generation_id')
                    ->validationMessages([
                        'unique' => 'La fecha ya ha sido registrada para este nivel',
                    ])
                    ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                    ->label('Fecha de término')
                    ->preload()
                    ->live()
                    ->rules(['required'])
                    ->required(),
            ])

            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->reorderable('order')
        ->headerActions([
            ImportAction::make()
                ->importer(GradeImporter::class)
                ->icon('icon-excel')
                ->label('Importar Grados')
                ,
            ExportAction::make()
                ->exporter(GradeExporter::class)
                ->icon('icon-excel')
                ->label('Exportar Grados'),




        ])

            ->columns([
                Tables\Columns\TextColumn::make('grado')
                    ->searchable()
                    ->alignCenter()
                    ->label('Nombre'),
                Tables\Columns\TextColumn::make('grado_numero')
                    ->searchable()
                    ->alignCenter()
                    ->label('Grado'),
                Tables\Columns\TextColumn::make('level.level')
                    ->searchable()
                    ->badge()
                    ->color(function ($record) { return Color::hex($record->level->color); })
                    ->alignCenter()
                    ->label('Nivel perteneciente'),
                Tables\Columns\TextColumn::make('generation.fecha_inicio')
                    ->badge()
                    ->searchable()
                    ->color(function ($record) {
                        return $record->generation->status == 0 ? 'danger' : 'success';
                    })
                    ->tooltip(function ($record) {
                        return $record->generation->status == 0 ? 'Esta generación está inactiva' : 'Activo';
                    })
                    ->alignCenter()
                    ->label('Fecha de inicio'),
                Tables\Columns\TextColumn::make('generation.fecha_termino')
                    ->searchable()
                    ->badge()
                    ->color(function ($record) {
                        return $record->generation->status == 0 ? 'danger' : 'success';
                    })
                    ->tooltip(function ($record) {
                        return $record->generation->status == 0 ? 'Esta generación está inactiva' : 'Activo';
                    })
                    ->label('Fecha de término')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('grupos')
                    ->badge()
                    ->searchable()
                    ->alignCenter()
                    ->label('Grupos asignados')









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

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGrades::route('/'),
            'create' => Pages\CreateGrade::route('/create'),
            'edit' => Pages\EditGrade::route('/{record}/edit'),
        ];
    }
}
