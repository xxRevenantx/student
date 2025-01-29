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


class LevelResource extends Resource
{
    protected static ?string $model = Level::class;

    protected static ?string $navigationIcon = 'icon-level';


    protected static ?string $modelLabel = 'Niveles';

    protected static ?string $navigationGroup = 'Niveles';

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
                    ->relationship('director', 'nombre'),
                Select::make('supervisor_id')->placeholder('Selecciona un supervisor')
                    ->label('Supervisor')
                    ->relationship('supervisor', 'nombre'),
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
                     TextColumn::make('color','Color')
                    ->searchable()
                    ->sortable(),
                     TextColumn::make('cct', 'C.C.T.')
                    ->searchable()
                    ->sortable(),
                     TextColumn::make('director.nombre', 'Director')

                    ->searchable()
                    ->sortable(),
                     TextColumn::make('supervisor.nombre', 'Supervisor')
                    ->searchable()
                    ->sortable(),

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
            'index' => Pages\ListLevels::route('/'),
            'create' => Pages\CreateLevel::route('/create'),
            'edit' => Pages\EditLevel::route('/{record}/edit'),
        ];
    }
}
