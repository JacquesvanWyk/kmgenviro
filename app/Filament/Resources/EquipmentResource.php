<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentResource\Pages;
use App\Models\Equipment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static ?string $navigationGroup = 'Equipment Rental';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_category_id')
                    ->relationship('equipmentCategory', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('specifications')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('typical_uses')
                    ->rows(4)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('photo')
                    ->image()
                    ->maxSize(5120)
                    ->directory('equipment'),
                Forms\Components\FileUpload::make('gallery_images')
                    ->image()
                    ->multiple()
                    ->maxFiles(10)
                    ->maxSize(5120)
                    ->directory('equipment/gallery')
                    ->columnSpanFull(),
                Forms\Components\Section::make('Rental Rates')
                    ->schema([
                        Forms\Components\TextInput::make('daily_rate')
                            ->numeric()
                            ->prefix('R')
                            ->required()
                            ->minValue(0)
                            ->step(0.01),
                        Forms\Components\TextInput::make('weekly_rate')
                            ->numeric()
                            ->prefix('R')
                            ->required()
                            ->minValue(0)
                            ->step(0.01),
                        Forms\Components\TextInput::make('monthly_rate')
                            ->numeric()
                            ->prefix('R')
                            ->required()
                            ->minValue(0)
                            ->step(0.01),
                    ])
                    ->columns(3),
                Forms\Components\Toggle::make('is_available')
                    ->default(true)
                    ->required(),
                Forms\Components\Toggle::make('is_featured')
                    ->default(false)
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->size(60)
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('equipmentCategory.name')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('daily_rate')
                    ->money('ZAR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('equipment_category_id')
                    ->relationship('equipmentCategory', 'name')
                    ->label('Category')
                    ->preload()
                    ->searchable(),
                Tables\Filters\TernaryFilter::make('is_available')
                    ->label('Available')
                    ->placeholder('All equipment')
                    ->trueLabel('Available only')
                    ->falseLabel('Unavailable only'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('All equipment')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
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
            'index' => Pages\ListEquipment::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
