<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingBookingResource\Pages;
use App\Models\TrainingBooking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrainingBookingResource extends Resource
{
    protected static ?string $model = TrainingBooking::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Training & Bookings';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('training_course_id')
                    ->relationship('trainingCourse', 'name')
                    ->required()
                    ->disabled(),
                Forms\Components\Select::make('training_schedule_id')
                    ->relationship('trainingSchedule', 'start_date')
                    ->disabled()
                    ->getOptionLabelFromRecordUsing(fn ($record) => $record->start_date->format('d M Y H:i')),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->disabled(),
                    ]),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->disabled(),
                        Forms\Components\TextInput::make('company')
                            ->disabled(),
                    ]),
                Forms\Components\TextInput::make('number_of_delegates')
                    ->numeric()
                    ->required()
                    ->disabled(),
                Forms\Components\Textarea::make('delegate_names')
                    ->rows(3)
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('special_requirements')
                    ->rows(3)
                    ->disabled()
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('preferred_date')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->required()
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
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
                Tables\Columns\TextColumn::make('trainingCourse.name')
                    ->label('Course')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('trainingSchedule.start_date')
                    ->label('Schedule')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                Tables\Columns\TextColumn::make('number_of_delegates')
                    ->label('Delegates')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'info',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'gray',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('training_course_id')
                    ->relationship('trainingCourse', 'name')
                    ->label('Course')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ])
                    ->multiple(),
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
            ])
            ->actions([
                Tables\Actions\Action::make('confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (TrainingBooking $record) => $record->status === 'pending')
                    ->action(fn (TrainingBooking $record) => $record->update(['status' => 'confirmed'])),
                Tables\Actions\Action::make('cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (TrainingBooking $record) => in_array($record->status, ['pending', 'confirmed']))
                    ->action(fn (TrainingBooking $record) => $record->update(['status' => 'cancelled'])),
                Tables\Actions\Action::make('sendEmail')
                    ->icon('heroicon-o-envelope')
                    ->color('info')
                    ->action(function () {
                        // Placeholder for email notification
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTrainingBookings::route('/'),
            'create' => Pages\CreateTrainingBooking::route('/create'),
            'edit' => Pages\EditTrainingBooking::route('/{record}/edit'),
        ];
    }
}
