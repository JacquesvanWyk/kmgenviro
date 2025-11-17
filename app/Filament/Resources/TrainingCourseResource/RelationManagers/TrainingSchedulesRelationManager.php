<?php

namespace App\Filament\Resources\TrainingCourseResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TrainingSchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'trainingSchedules';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DateTimePicker::make('start_date')
                    ->required()
                    ->seconds(false),
                Forms\Components\DateTimePicker::make('end_date')
                    ->required()
                    ->seconds(false)
                    ->after('start_date'),
                Forms\Components\TextInput::make('location')
                    ->maxLength(255)
                    ->placeholder('e.g., Johannesburg Training Centre'),
                Forms\Components\Toggle::make('is_online')
                    ->default(false),
                Forms\Components\TextInput::make('available_seats')
                    ->numeric()
                    ->required()
                    ->default(15),
                Forms\Components\TextInput::make('price_override')
                    ->numeric()
                    ->prefix('R')
                    ->placeholder('Leave empty to use course price'),
                Forms\Components\Textarea::make('notes')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('start_date')
            ->columns([
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime('d M Y H:i'),
                Tables\Columns\TextColumn::make('location')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('available_seats')
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        $state > 5 => 'success',
                        $state > 0 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\TextColumn::make('trainingBookings_count')
                    ->counts('trainingBookings')
                    ->label('Bookings')
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }
}
