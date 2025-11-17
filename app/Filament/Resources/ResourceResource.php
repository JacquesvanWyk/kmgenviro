<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ResourceResource\Pages;
use App\Models\Resource as ResourceModel;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ResourceResource extends Resource
{
    protected static ?string $model = ResourceModel::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-arrow-down';

    protected static ?string $navigationGroup = 'Content Management';

    protected static ?int $navigationSort = 7;

    protected static ?string $modelLabel = 'Downloadable Resource';

    protected static ?string $pluralModelLabel = 'Downloadable Resources';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('file')
                    ->required()
                    ->acceptedFileTypes(['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'])
                    ->maxSize(10240)
                    ->directory('resources')
                    ->columnSpanFull(),
                Forms\Components\Select::make('category')
                    ->options([
                        'Company Profile' => 'Company Profile',
                        'Brochure' => 'Brochure',
                        'Technical Guide' => 'Technical Guide',
                        'Case Study' => 'Case Study',
                        'Compliance Document' => 'Compliance Document',
                    ])
                    ->required()
                    ->searchable(),
                Forms\Components\Toggle::make('requires_details')
                    ->label('Requires details (Lead capture)')
                    ->helperText('When enabled, users must provide their details before downloading this resource')
                    ->default(false)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
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
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->searchable(),
                Tables\Columns\TextColumn::make('file_type')
                    ->badge()
                    ->label('Type')
                    ->formatStateUsing(fn (string $state): string => strtoupper($state)),
                Tables\Columns\TextColumn::make('file_size')
                    ->label('Size')
                    ->formatStateUsing(function ($state): string {
                        if (! $state) {
                            return 'N/A';
                        }
                        if ($state < 1024) {
                            return $state.' B';
                        } elseif ($state < 1048576) {
                            return round($state / 1024, 2).' KB';
                        } else {
                            return round($state / 1048576, 2).' MB';
                        }
                    }),
                Tables\Columns\TextColumn::make('download_count')
                    ->label('Downloads')
                    ->sortable(),
                Tables\Columns\IconColumn::make('requires_details')
                    ->boolean()
                    ->label('Lead Capture'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Company Profile' => 'Company Profile',
                        'Brochure' => 'Brochure',
                        'Technical Guide' => 'Technical Guide',
                        'Case Study' => 'Case Study',
                        'Compliance Document' => 'Compliance Document',
                    ]),
                Tables\Filters\TernaryFilter::make('requires_details')
                    ->label('Lead Capture')
                    ->placeholder('All resources')
                    ->trueLabel('Requires details')
                    ->falseLabel('No details required'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Active')
                    ->placeholder('All resources')
                    ->trueLabel('Active only')
                    ->falseLabel('Inactive only'),
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function (ResourceModel $record) {
                        $record->increment('download_count');

                        return Storage::download($record->file);
                    })
                    ->visible(fn (ResourceModel $record) => $record->file !== null),
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
            'index' => Pages\ListResources::route('/'),
            'create' => Pages\CreateResource::route('/create'),
            'edit' => Pages\EditResource::route('/{record}/edit'),
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
