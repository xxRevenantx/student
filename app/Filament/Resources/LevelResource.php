<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LevelResource\Pages;
use App\Filament\Resources\LevelResource\RelationManagers;
use App\Models\Level;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\Layout\Split;

use App\Filament\Exports\LevelExporter;
use App\Filament\Resources\LevelResource\RelationManagers\DirectorRelationManager;
use App\Models\Director;
use App\Models\Supervisor;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Columns\ColorColumn;

class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static ?string $navigationIcon = 'icon-level';


    protected static ?string $modelLabel = 'Niveles';

    protected static ?string $navigationGroup = 'ESTRUCTURA ACADÉMICA';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->schema([

                    FileUpload::make('imagen')
                    ->directory('imagenes')
                    ->storeFileNamesIn('original_filename')
                    ->columnSpan('full') ,


                    Forms\Components\TextInput::make('level')->placeholder('Ejemplo: Preescolar, Primaria, Secundaria')
                    ->label('Nivel')
                    ->rules('required')
                    ->unique(ignoreRecord: true) // IGNORAR EL CAMPO SI YA HA SIDO REGISTRADO
                    ->live(onBlur: true)
                    ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                        if (($get('slug') ?? '') !== Str::slug($old)) {
                            return;
                        }
                        $set('slug', Str::slug($state)); }),
                Forms\Components\TextInput::make('slug')->placeholder('Ejemplo: preescolar, primaria, secundaria')
                     ->rules('required')
                     ->readonly()
                    ->label('Ruta'),
                Forms\Components\ColorPicker::make('color')
                    ->label('Color'),
                Forms\Components\TextInput::make('cct')->placeholder('Ejemplo: 21DPR1234A')
                    ->label('C.C.T.'),

                    Select::make('director_id') -> placeholder('Selecciona un director')
                    ->label('Director')
                    ->relationship(
                        name: 'director',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('apellido_paterno')->orderBy('apellido_materno'))
                    ->getOptionLabelFromRecordUsing(fn (Director $record) => "{$record->nombre} {$record->apellido_paterno} {$record->apellido_materno} "),

                    Select::make('supervisor_id') -> placeholder('Selecciona un supervisor')
                    ->label('Supervisor')
                    ->relationship(
                        name: 'supervisor',
                        modifyQueryUsing: fn (Builder $query) => $query->orderBy('apellido_paterno')->orderBy('apellido_materno'))
                    ->getOptionLabelFromRecordUsing(fn (Supervisor $record) => "{$record->nombre} {$record->apellido_paterno} {$record->apellido_materno} ")
                    ,
                ])->columns(2),

                    ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->headerActions([
            ExportAction::make()
                ->exporter(LevelExporter::class)
                ->label('Exportar')
                ->icon('icon-excel')
        ])

            ->columns([
                     TextColumn::make('order' ,'#')
                    ->searchable()
                    ->sortable(),
                     ImageColumn::make('imagen', 'Logo')->circular(),
                     TextColumn::make('level' ,'Nivel')
                    ->searchable()
                    ->sortable(),
                     TextColumn::make("slug",'Ruta')
                    ->searchable()
                    ->sortable(),
                     ColorColumn::make('color','Color')
                    ->searchable()
                    ->sortable(),
                     TextColumn::make('cct', 'C.C.T.')
                    ->searchable()
                    ->color('primary')
                    ->sortable(),
                     TextColumn::make('director', 'Director')
                    ->formatStateUsing(fn ($state): string => is_object($state) ? "{$state->nombre} {$state->apellido_paterno} {$state->apellido_materno}" : ''),
                    //  ->formatStateUsing(fn ($state): string => is_object($state) ? $state->nombre . ' ' . $state->apellido_paterno . ' ' . $state->apellido_materno : ''),

                    TextColumn::make('supervisor', 'Supervisor')
                        ->formatStateUsing(fn ($state): string => is_object($state) ? $state->nombre . ' ' . $state->apellido_paterno . ' ' . $state->apellido_materno : ''),



            ])


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

                ExportBulkAction::make()
                ->exporter(LevelExporter::class)
                ->label('Exportar seleccionados')
                ->icon('icon-excel')
            ]);
    }

    public static function getRelations(): array
    {
        return [
            DirectorRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit' => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
