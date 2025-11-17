<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrainingCourseResource\Pages;
use App\Filament\Resources\TrainingCourseResource\RelationManagers;
use App\Models\TrainingCourse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TrainingCourseResource extends Resource
{
    protected static ?string $model = TrainingCourse::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Training & Bookings';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('short_description')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('full_description')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('duration')
                    ->maxLength(255)
                    ->placeholder('e.g., 2 days, 16 hours'),
                Forms\Components\TextInput::make('accreditation')
                    ->maxLength(255)
                    ->placeholder('e.g., SACPCMP, EAPASA'),
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('R')
                    ->placeholder('0.00'),
                Forms\Components\TextInput::make('max_delegates')
                    ->numeric()
                    ->placeholder('e.g., 15'),
                Forms\Components\RichEditor::make('course_outline')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('target_audience')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('prerequisites')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->maxSize(5120)
                    ->directory('training-courses/thumbnails'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\Toggle::make('is_featured')
                    ->default(false),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Section::make('SEO')
                    ->schema([
                        Forms\Components\TextInput::make('meta_title')
                            ->maxLength(255),
                        Forms\Components\Textarea::make('meta_description')
                            ->rows(3),
                    ])
                    ->collapsed(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('ZAR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('trainingSchedules_count')
                    ->counts('trainingSchedules')
                    ->label('Schedules')
                    ->badge()
                    ->color('info'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All courses')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('All courses')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TrainingSchedulesRelationManager::class,
            RelationManagers\TrainingBookingsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrainingCourses::route('/'),
            'create' => Pages\CreateTrainingCourse::route('/create'),
            'edit' => Pages\EditTrainingCourse::route('/{record}/edit'),
        ];
    }
}
