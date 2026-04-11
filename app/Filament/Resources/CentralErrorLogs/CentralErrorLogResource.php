<?php

namespace App\Filament\Resources\CentralErrorLogs;

use App\Filament\Resources\CentralErrorLogs\Pages\ManageCentralErrorLogs;
use App\Models\CentralErrorLog;
use BackedEnum;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
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
            ->columns(1)
            ->components([
                Section::make('Summary')
                    ->schema([
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
                    ])
                    ->columns([
                        'md' => 2,
                        'xl' => 4,
                    ])
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Exception')
                    ->schema([
                        TextEntry::make('exception_class')
                            ->placeholder('None'),
                        TextEntry::make('error_code')
                            ->placeholder('None'),
                        TextEntry::make('file_path')
                            ->placeholder('None')
                            ->extraAttributes(['class' => 'break-all'])
                            ->columnSpanFull(),
                        TextEntry::make('line_number')
                            ->placeholder('None'),
                    ])
                    ->columns([
                        'md' => 2,
                    ])
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Request Context')
                    ->schema([
                        TextEntry::make('route')
                            ->placeholder('None'),
                        TextEntry::make('method')
                            ->placeholder('None'),
                        TextEntry::make('status_code')
                            ->placeholder('None'),
                        TextEntry::make('request_id')
                            ->copyable()
                            ->placeholder('None'),
                        TextEntry::make('trace_id')
                            ->copyable()
                            ->placeholder('None'),
                        TextEntry::make('user_id')
                            ->label('User')
                            ->formatStateUsing(fn (?int $state): string => $state ? 'User #'.$state : 'Guest'),
                        TextEntry::make('ip_address')
                            ->placeholder('None'),
                        TextEntry::make('hostname')
                            ->placeholder('None'),
                    ])
                    ->columns([
                        'md' => 2,
                        'xl' => 3,
                    ])
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Full Message')
                    ->schema([
                        TextEntry::make('message')
                            ->hiddenLabel()
                            ->formatStateUsing(fn (?string $state): string => self::limitText($state, 4000))
                            ->extraAttributes(['class' => 'break-words whitespace-pre-wrap'])
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Stack Trace')
                    ->schema([
                        TextEntry::make('stack_trace')
                            ->hiddenLabel()
                            ->formatStateUsing(fn (?string $state): string => self::limitText($state, 6000))
                            ->placeholder('No stack trace captured')
                            ->extraAttributes(['class' => 'break-words whitespace-pre-wrap'])
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Context')
                    ->schema([
                        TextEntry::make('context')
                            ->hiddenLabel()
                            ->formatStateUsing(fn (mixed $state): string => self::formatStructuredValue($state))
                            ->extraAttributes(['class' => 'break-words whitespace-pre-wrap'])
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->compact(),
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
                    ->visibleFrom('md')
                    ->width('11rem')
                    ->grow(false)
                    ->sortable(),
                TextColumn::make('severity')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'critical', 'error' => 'danger',
                        'warning' => 'warning',
                        default => 'info',
                    })
                    ->visibleFrom('sm')
                    ->width('6rem')
                    ->grow(false)
                    ->sortable(),
                TextColumn::make('handled')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Handled' : 'Unhandled')
                    ->color(fn (bool $state): string => $state ? 'success' : 'danger')
                    ->visibleFrom('lg')
                    ->width('7rem')
                    ->grow(false)
                    ->sortable(),
                TextColumn::make('message')
                    ->searchable()
                    ->limit(75)
                    ->lineClamp(2)
                    ->wrap()
                    ->visibleFrom('xl')
                    ->width('22rem')
                    ->grow()
                    ->extraCellAttributes(['class' => 'break-words whitespace-normal']),
                TextColumn::make('environment')
                    ->badge()
                    ->visibleFrom('2xl')
                    ->width('7rem')
                    ->grow(false)
                    ->sortable(),
                TextColumn::make('status_code')
                    ->label('Status')
                    ->visibleFrom('2xl')
                    ->width('5rem')
                    ->grow(false)
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('exception_class')
                    ->label('Exception')
                    ->searchable()
                    ->limit(45)
                    ->lineClamp(1)
                    ->visibleFrom('2xl')
                    ->width('12rem')
                    ->grow(false)
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('route')
                    ->searchable()
                    ->limit(45)
                    ->lineClamp(1)
                    ->visibleFrom('2xl')
                    ->width('12rem')
                    ->grow(false)
                    ->toggleable(isToggledHiddenByDefault: true),
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
                    ->modalHeading(fn (CentralErrorLog $record): string => 'Error Log #'.$record->id)
                    ->modalWidth(Width::ThreeExtraLarge)
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

    private static function limitText(?string $state, int $limit): string
    {
        return $state ? Str::limit($state, $limit) : 'None';
    }

    private static function formatStructuredValue(mixed $state): string
    {
        if ($state === null || $state === '') {
            return 'None';
        }

        if (is_array($state)) {
            return json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?: 'None';
        }

        if (is_bool($state)) {
            return $state ? 'true' : 'false';
        }

        return Str::limit((string) $state, 4000);
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
