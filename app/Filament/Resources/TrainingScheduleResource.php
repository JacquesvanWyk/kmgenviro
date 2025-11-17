<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingScheduleResource\Pages;
use App\Models\TrainingSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TrainingScheduleResource extends Resource
{
    protected static ?string $model = TrainingSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Training & Bookings';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('training_course_id')
                    ->relationship('trainingCourse', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('trainingCourse.name')
                    ->label('Course')
                    ->searchable()
                    ->sortable(),
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
                Tables\Filters\SelectFilter::make('training_course_id')
                    ->relationship('trainingCourse', 'name')
                    ->label('Course')
                    ->searchable()
                    ->preload(),
                Tables\Filters\Filter::make('start_date')
                    ->form([
                        Forms\Components\DatePicker::make('from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('until')
                            ->label('Until'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'], fn ($q) => $q->whereDate('start_date', '>=', $data['from']))
                            ->when($data['until'], fn ($q) => $q->whereDate('start_date', '<=', $data['until']));
                    }),
                Tables\Filters\TernaryFilter::make('is_online')
                    ->label('Online')
                    ->placeholder('All schedules')
                    ->trueLabel('Online only')
                    ->falseLabel('In-person only'),
            ])
            ->actions([
                Tables\Actions\Action::make('duplicate')
                    ->icon('heroicon-o-document-duplicate')
                    ->form([
                        Forms\Components\DateTimePicker::make('start_date')
                            ->required()
                            ->seconds(false),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->required()
                            ->seconds(false),
                    ])
                    ->action(function (TrainingSchedule $record, array $data): void {
                        $newSchedule = $record->replicate();
                        $newSchedule->start_date = $data['start_date'];
                        $newSchedule->end_date = $data['end_date'];
                        $newSchedule->save();
                    }),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
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
            'index' => Pages\ListTrainingSchedules::route('/'),
            'create' => Pages\CreateTrainingSchedule::route('/create'),
            'edit' => Pages\EditTrainingSchedule::route('/{record}/edit'),
        ];
    }
}
