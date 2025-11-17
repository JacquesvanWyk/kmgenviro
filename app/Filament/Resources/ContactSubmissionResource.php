<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactSubmissionResource\Pages;
use App\Models\ContactSubmission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContactSubmissionResource extends Resource
{
    protected static ?string $model = ContactSubmission::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    protected static ?string $navigationGroup = 'Inquiries';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Contact Details')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->label('Inquiry Type')
                            ->options([
                                'general_inquiry' => 'General Inquiry',
                                'quote_request' => 'Quote Request',
                                'training_inquiry' => 'Training Inquiry',
                                'equipment_rental' => 'Equipment Rental',
                            ])
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->disabled()
                                    ->dehydrated(),

                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->disabled()
                                    ->dehydrated(),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->disabled()
                                    ->dehydrated(),

                                Forms\Components\TextInput::make('company')
                                    ->disabled()
                                    ->dehydrated(),
                            ]),

                        Forms\Components\TextInput::make('subject')
                            ->columnSpanFull()
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Textarea::make('message')
                            ->rows(4)
                            ->columnSpanFull()
                            ->disabled()
                            ->dehydrated(),
                    ]),

                Forms\Components\Section::make('Additional Details')
                    ->schema([
                        Forms\Components\TextInput::make('service_type')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\TextInput::make('project_name')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('location')
                                    ->disabled()
                                    ->dehydrated(),

                                Forms\Components\TextInput::make('sector')
                                    ->disabled()
                                    ->dehydrated(),
                            ]),

                        Forms\Components\TextInput::make('timeline')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->collapsed()
                    ->visible(fn (?ContactSubmission $record): bool => $record?->service_type || $record?->project_name || $record?->location || $record?->sector || $record?->timeline),

                Forms\Components\Section::make('Status & Notes')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'new' => 'New',
                                'contacted' => 'Contacted',
                                'converted' => 'Converted',
                                'closed' => 'Closed',
                            ])
                            ->required()
                            ->default('new'),

                        Forms\Components\Textarea::make('notes')
                            ->label('Admin Notes')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Technical Information')
                    ->schema([
                        Forms\Components\TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Textarea::make('user_agent')
                            ->label('User Agent')
                            ->rows(2)
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->collapsed()
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'general_inquiry' => 'gray',
                        'quote_request' => 'info',
                        'training_inquiry' => 'success',
                        'equipment_rental' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'general_inquiry' => 'General Inquiry',
                        'quote_request' => 'Quote Request',
                        'training_inquiry' => 'Training Inquiry',
                        'equipment_rental' => 'Equipment Rental',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('subject')
                    ->searchable()
                    ->limit(50),

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'new' => 'danger',
                        'contacted' => 'warning',
                        'converted' => 'success',
                        'closed' => 'gray',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Submitted At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'general_inquiry' => 'General Inquiry',
                        'quote_request' => 'Quote Request',
                        'training_inquiry' => 'Training Inquiry',
                        'equipment_rental' => 'Equipment Rental',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'new' => 'New',
                        'contacted' => 'Contacted',
                        'converted' => 'Converted',
                        'closed' => 'Closed',
                    ]),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('markAsContacted')
                    ->label('Mark as Contacted')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (ContactSubmission $record): bool => $record->status === 'new')
                    ->action(function (ContactSubmission $record): void {
                        $record->update(['status' => 'contacted']);

                        Notification::make()
                            ->success()
                            ->title('Marked as contacted')
                            ->body('The submission has been marked as contacted.')
                            ->send();
                    }),
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
            'index' => Pages\ListContactSubmissions::route('/'),
            'create' => Pages\CreateContactSubmission::route('/create'),
            'view' => Pages\ViewContactSubmission::route('/{record}'),
            'edit' => Pages\EditContactSubmission::route('/{record}/edit'),
        ];
    }
}
