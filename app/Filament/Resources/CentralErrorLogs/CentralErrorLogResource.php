<?php

namespace App\Filament\Resources\CentralErrorLogs;

use App\Filament\Resources\CentralErrorLogs\Pages\ManageCentralErrorLogs;
use App\Models\CentralErrorLog;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use UnitEnum;

class CentralErrorLogResource extends Resource
{
    protected static ?string $model = CentralErrorLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBugAnt;

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Error Logs';

    protected static ?string $modelLabel = 'Error Log';

    protected static ?string $pluralModelLabel = 'Error Logs';

    protected static ?string $recordTitleAttribute = 'message';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('occurred_at')
                    ->formatStateUsing(fn (CentralErrorLog $record): string => self::formatOccurredAt($record)),
                TextEntry::make('severity')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'critical', 'error' => 'danger',
                        'warning' => 'warning',
                        default => 'info',
                    }),
                TextEntry::make('environment')
                    ->badge(),
                TextEntry::make('handled')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Handled' : 'Unhandled')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
                TextEntry::make('message')
                    ->columnSpanFull(),
                TextEntry::make('exception_class')
                    ->placeholder('None'),
                TextEntry::make('route')
                    ->placeholder('None'),
                TextEntry::make('method')
                    ->placeholder('None'),
                TextEntry::make('status_code')
                    ->placeholder('None'),
                TextEntry::make('request_id')
                    ->copyable()
                    ->placeholder('None'),
                TextEntry::make('file_path')
                    ->placeholder('None')
                    ->columnSpanFull(),
                TextEntry::make('line_number')
                    ->placeholder('None'),
                TextEntry::make('stack_trace')
                    ->placeholder('No stack trace captured')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('message')
            ->defaultSort('occurred_at', 'desc')
            ->columns([
                TextColumn::make('occurred_at')
                    ->label('Occurred')
                    ->formatStateUsing(fn (CentralErrorLog $record): string => self::formatOccurredAt($record))
                    ->sortable(),
                TextColumn::make('severity')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'critical', 'error' => 'danger',
                        'warning' => 'warning',
                        default => 'info',
                    })
                    ->sortable(),
                TextColumn::make('environment')
                    ->badge()
                    ->sortable(),
                TextColumn::make('message')
                    ->searchable()
                    ->limit(90)
                    ->wrap(),
                TextColumn::make('exception_class')
                    ->label('Exception')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('route')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('status_code')
                    ->label('Status')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('handled')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Handled' : 'Unhandled')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('severity')
                    ->options([
                        'debug' => 'Debug',
                        'info' => 'Info',
                        'notice' => 'Notice',
                        'warning' => 'Warning',
                        'error' => 'Error',
                        'critical' => 'Critical',
                    ]),
                SelectFilter::make('environment')
                    ->options([
                        'local' => 'Local',
                        'staging' => 'Staging',
                        'production' => 'Production',
                    ]),
                SelectFilter::make('handled')
                    ->options([
                        '1' => 'Handled',
                        '0' => 'Unhandled',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (($data['value'] ?? null) === null || $data['value'] === '') {
                            return $query;
                        }

                        return $query->where('handled', $data['value'] === '1');
                    }),
                Filter::make('occurred_at')
                    ->schema([
                        DatePicker::make('from')
                            ->label('Occurred from'),
                        DatePicker::make('until')
                            ->label('Occurred until'),
                    ])
                    ->query(fn (Builder $query, array $data): Builder => $query
                        ->when($data['from'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('occurred_at', '>=', $date))
                        ->when($data['until'] ?? null, fn (Builder $query, string $date): Builder => $query->whereDate('occurred_at', '<=', $date))),
            ])
            ->recordActions([
                ViewAction::make()
                    ->slideOver(),
            ])
            ->toolbarActions([]);
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('view-platform-error-logs');
    }

    private static function formatOccurredAt(CentralErrorLog $record): string
    {
        return $record
            ->occurredAtForTimezone(auth()->user()?->timezone)
            ?->format('M j, Y g:i A T') ?? 'None';
    }

    public static function canView(Model $record): bool
    {
        return Gate::allows('view-platform-error-logs');
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    public static function canDeleteAny(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCentralErrorLogs::route('/'),
        ];
    }
}
