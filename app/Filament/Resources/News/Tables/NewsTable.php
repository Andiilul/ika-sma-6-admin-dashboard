<?php

namespace App\Filament\Resources\News\Tables;

use App\Enums\NewsStatus;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('excerpt')
                    ->label('Excerpt')
                    ->limit(80)
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof NewsStatus ? $state->value : (string) $state)
                    ->sortable(),

                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('published_at')
                    ->label('Published')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft'     => 'Draft',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                        'archived'  => 'Archived',
                    ]),

                Filter::make('published_range')
                    ->label('Published Range')
                    ->form([
                        DatePicker::make('from')->label('From')->native(false),
                        DatePicker::make('until')->label('Until')->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('published_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('published_at', '<=', $date));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('published_at', 'desc');
    }
}