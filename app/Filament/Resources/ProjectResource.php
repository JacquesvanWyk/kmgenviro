<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('sector_id')
                    ->relationship('sector', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Grid::make(2)
                    ->schema([
                        Forms\Components\TextInput::make('client_name')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('location')
                            ->maxLength(255),
                    ]),
                Forms\Components\Select::make('province')
                    ->options([
                        'Eastern Cape' => 'Eastern Cape',
                        'Free State' => 'Free State',
                        'Gauteng' => 'Gauteng',
                        'KwaZulu-Natal' => 'KwaZulu-Natal',
                        'Limpopo' => 'Limpopo',
                        'Mpumalanga' => 'Mpumalanga',
                        'Northern Cape' => 'Northern Cape',
                        'North West' => 'North West',
                        'Western Cape' => 'Western Cape',
                    ])
                    ->searchable(),
                Forms\Components\Textarea::make('short_description')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('full_description')
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('services_provided')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('outcomes')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('featured_image')
                    ->image()
                    ->maxSize(5120)
                    ->directory('projects'),
                Forms\Components\FileUpload::make('gallery_images')
                    ->image()
                    ->multiple()
                    ->maxFiles(10)
                    ->maxSize(5120)
                    ->directory('projects/gallery')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('completion_date'),
                Forms\Components\Toggle::make('is_featured')
                    ->default(false)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->required(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->required(),
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
                Tables\Columns\ImageColumn::make('featured_image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sector.name')
                    ->label('Sector')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('province')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('sector_id')
                    ->relationship('sector', 'name')
                    ->label('Sector')
                    ->searchable()
                    ->preload(),
                Tables\Filters\SelectFilter::make('province')
                    ->options([
                        'Eastern Cape' => 'Eastern Cape',
                        'Free State' => 'Free State',
                        'Gauteng' => 'Gauteng',
                        'KwaZulu-Natal' => 'KwaZulu-Natal',
                        'Limpopo' => 'Limpopo',
                        'Mpumalanga' => 'Mpumalanga',
                        'Northern Cape' => 'Northern Cape',
                        'North West' => 'North West',
                        'Western Cape' => 'Western Cape',
                    ])
                    ->searchable(),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->placeholder('All projects')
                    ->trueLabel('Featured only')
                    ->falseLabel('Not featured'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All projects')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
                Tables\Filters\Filter::make('completion_date')
                    ->form([
                        Forms\Components\DatePicker::make('completed_from')
                            ->label('Completed from'),
                        Forms\Components\DatePicker::make('completed_until')
                            ->label('Completed until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['completed_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('completion_date', '>=', $date),
                            )
                            ->when(
                                $data['completed_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('completion_date', '<=', $date),
                            );
                    }),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
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
