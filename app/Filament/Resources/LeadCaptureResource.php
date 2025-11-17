<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LeadCaptureResource\Pages;
use App\Models\LeadCapture;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class LeadCaptureResource extends Resource
{
    protected static ?string $model = LeadCapture::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    protected static ?string $navigationGroup = 'Inquiries';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Lead Information')
                    ->schema([
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

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('province')
                                    ->disabled()
                                    ->dehydrated(),

                                Forms\Components\TextInput::make('source')
                                    ->disabled()
                                    ->dehydrated()
                                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                                        'resource_download' => 'Resource Download',
                                        'newsletter' => 'Newsletter',
                                        'contact_form' => 'Contact Form',
                                        default => $state ?? '',
                                    }),
                            ]),
                    ]),

                Forms\Components\Section::make('Source Details')
                    ->schema([
                        Forms\Components\Select::make('resource_id')
                            ->label('Downloaded Resource')
                            ->relationship('resource', 'title')
                            ->disabled()
                            ->dehydrated(),
                    ])
                    ->visible(fn (?LeadCapture $record): bool => $record?->resource_id !== null),
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

                Tables\Columns\TextColumn::make('company')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('province')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('source')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'resource_download' => 'success',
                        'newsletter' => 'info',
                        'contact_form' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'resource_download' => 'Resource Download',
                        'newsletter' => 'Newsletter',
                        'contact_form' => 'Contact Form',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('resource.title')
                    ->label('Downloaded Resource')
                    ->sortable()
                    ->toggleable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Captured At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('source')
                    ->options([
                        'resource_download' => 'Resource Download',
                        'newsletter' => 'Newsletter',
                        'contact_form' => 'Contact Form',
                    ]),

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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('exportToCsv')
                        ->label('Export to CSV')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->action(function (Collection $records) {
                            $filename = 'leads_'.now()->format('Y-m-d_His').'.csv';
                            $headers = [
                                'Content-Type' => 'text/csv',
                                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
                            ];

                            $callback = function () use ($records) {
                                $file = fopen('php://output', 'w');

                                fputcsv($file, ['Name', 'Email', 'Phone', 'Company', 'Province', 'Source', 'Resource', 'Captured At']);

                                foreach ($records as $record) {
                                    fputcsv($file, [
                                        $record->name,
                                        $record->email,
                                        $record->phone,
                                        $record->company,
                                        $record->province,
                                        match ($record->source) {
                                            'resource_download' => 'Resource Download',
                                            'newsletter' => 'Newsletter',
                                            'contact_form' => 'Contact Form',
                                            default => $record->source,
                                        },
                                        $record->resource?->title ?? '',
                                        $record->created_at->format('Y-m-d H:i:s'),
                                    ]);
                                }

                                fclose($file);
                            };

                            return response()->stream($callback, 200, $headers);
                        })
                        ->deselectRecordsAfterCompletion(),

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
            'index' => Pages\ListLeadCaptures::route('/'),
            'view' => Pages\ViewLeadCapture::route('/{record}'),
        ];
    }
}
