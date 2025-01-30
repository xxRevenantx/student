<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GenerationResource\Pages;
use App\Filament\Resources\GenerationResource\RelationManagers;
use App\Models\Generation;
use Filament\Forms;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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

                Forms\Components\TextInput::make('start_year')->placeholder('Año de inicio')
                ->label('Año de inicio')
                ->rules('required')
                ,
                Forms\Components\TextInput::make('end_year')->placeholder('Año de término')
                ->label('Año de término')
                ->rules('required')
                ,

                Toggle::make('status')
                ->label('Status')
                ->default(1)

                ,

            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('start_year')
                    ->searchable()
                    ->sortable()
                    ->label('Año de inicio')
                    ,
                Tables\Columns\TextColumn::make('end_year')
                    ->searchable()
                    ->sortable()
                    ->label('Año de término')
                    ,
                    ToggleColumn::make('status')
                    ,

            ])
            ->filters([
                //
            ])
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
