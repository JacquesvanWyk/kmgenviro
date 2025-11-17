<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EquipmentRentalQuoteResource\Pages;
use App\Models\EquipmentRentalQuote;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EquipmentRentalQuoteResource extends Resource
{
    protected static ?string $model = EquipmentRentalQuote::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationGroup = 'Equipment Rental';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('equipment_id')
                    ->relationship('equipment', 'name')
                    ->disabled(),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('company')
                            ->disabled(),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->disabled(),
                    ]),
                Forms\Components\Textarea::make('equipment_requested')
                    ->rows(3)
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('rental_duration')
                            ->disabled(),
                        Forms\Components\DatePicker::make('start_date')
                            ->disabled(),
                    ]),
                Forms\Components\TextInput::make('location')
                    ->disabled(),
                Forms\Components\Toggle::make('delivery_required')
                    ->disabled(),
                Forms\Components\Textarea::make('message')
                    ->rows(3)
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'quoted' => 'Quoted',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->default('pending'),
                Forms\Components\Textarea::make('notes')
                    ->label('Admin Notes')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('company')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('equipment.name')
                    ->label('Equipment')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('rental_duration')
                    ->label('Duration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'info',
                        'quoted' => 'warning',
                        'confirmed' => 'success',
                        'completed' => 'gray',
                        'cancelled' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('equipment_id')
                    ->relationship('equipment', 'name')
                    ->label('Equipment')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'quoted' => 'Quoted',
                        'confirmed' => 'Confirmed',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->multiple(),
                Tables\Filters\TernaryFilter::make('delivery_required')
                    ->label('Delivery Required')
                    ->placeholder('All quotes')
                    ->trueLabel('Delivery required')
                    ->falseLabel('No delivery'),
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('created_at', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('created_at', '<=', $data['until']));
                    }),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('markQuoted')
                    ->label('Mark as Quoted')
                    ->icon('heroicon-o-document-check')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->visible(fn (EquipmentRentalQuote $record) => $record->status === 'pending')
                    ->action(fn (EquipmentRentalQuote $record) => $record->update(['status' => 'quoted'])),
                Tables\Actions\Action::make('markConfirmed')
                    ->label('Mark as Confirmed')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (EquipmentRentalQuote $record) => in_array($record->status, ['pending', 'quoted']))
                    ->action(fn (EquipmentRentalQuote $record) => $record->update(['status' => 'confirmed'])),
                Tables\Actions\Action::make('sendQuoteEmail')
                    ->label('Send Quote')
                    ->icon('heroicon-o-envelope')
                    ->color('info')
                    ->action(function () {
                        // Placeholder for email notification
                    }),
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
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListEquipmentRentalQuotes::route('/'),
            'create' => Pages\CreateEquipmentRentalQuote::route('/create'),
            'edit' => Pages\EditEquipmentRentalQuote::route('/{record}/edit'),
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
