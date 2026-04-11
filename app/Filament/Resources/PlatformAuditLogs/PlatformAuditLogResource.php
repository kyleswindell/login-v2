<?php

namespace App\Filament\Resources\PlatformAuditLogs;

use App\Filament\Resources\PlatformAuditLogs\Pages\ManagePlatformAuditLogs;
use App\Models\PlatformAuditLog;
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

class PlatformAuditLogResource extends Resource
{
    protected static ?string $model = PlatformAuditLog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;

    protected static string|UnitEnum|null $navigationGroup = 'Operations';

    protected static ?string $navigationLabel = 'Audit Logs';

    protected static ?string $modelLabel = 'Audit Log';

    protected static ?string $pluralModelLabel = 'Audit Logs';

    protected static ?string $recordTitleAttribute = 'event_type';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Event Summary')
                    ->schema([
                        TextEntry::make('occurred_at')
                            ->formatStateUsing(fn (PlatformAuditLog $record): string => self::formatOccurredAt($record)),
                        TextEntry::make('event_type')
                            ->label('Event type')
                            ->formatStateUsing(fn (?string $state): string => self::limitText($state, 180))
                            ->extraAttributes(['class' => 'break-words whitespace-pre-wrap']),
                        TextEntry::make('action'),
                        TextEntry::make('result')
                            ->badge()
                            ->color(fn (?string $state): string => $state === 'success' ? 'success' : 'danger'),
                        TextEntry::make('severity')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'critical', 'error' => 'danger',
                                'warning' => 'warning',
                                default => 'info',
                            }),
                    ])
                    ->columns([
                        'md' => 2,
                        'xl' => 4,
                    ])
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Actor And Subject')
                    ->schema([
                        TextEntry::make('actorUser.name')
                            ->label('Actor name')
                            ->placeholder('System'),
                        TextEntry::make('actorUser.email')
                            ->label('Actor email')
                            ->placeholder('None'),
                        TextEntry::make('actor_type')
                            ->placeholder('None'),
                        TextEntry::make('actor_id')
                            ->placeholder('None'),
                        TextEntry::make('subject_type')
                            ->placeholder('None'),
                        TextEntry::make('subject_id')
                            ->placeholder('None'),
                    ])
                    ->columns([
                        'md' => 2,
                        'xl' => 3,
                    ])
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Request Context')
                    ->schema([
                        TextEntry::make('route')
                            ->placeholder('None'),
                        TextEntry::make('method')
                            ->placeholder('None'),
                        TextEntry::make('request_id')
                            ->copyable()
                            ->placeholder('None'),
                        TextEntry::make('trace_id')
                            ->copyable()
                            ->placeholder('None'),
                        TextEntry::make('ip_address')
                            ->placeholder('None'),
                    ])
                    ->columns([
                        'md' => 2,
                        'xl' => 3,
                    ])
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Metadata')
                    ->schema([
                        TextEntry::make('metadata')
                            ->hiddenLabel()
                            ->formatStateUsing(fn (mixed $state): string => self::formatStructuredValue($state))
                            ->extraAttributes(['class' => 'break-words whitespace-pre-wrap'])
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed()
                    ->columnSpanFull()
                    ->compact(),
                Section::make('Client Details')
                    ->schema([
                        TextEntry::make('user_agent')
                            ->label('User agent')
                            ->formatStateUsing(fn (?string $state): string => self::limitText($state, 1000))
                            ->placeholder('None')
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
            ->recordTitleAttribute('event_type')
            ->defaultSort('occurred_at', 'desc')
            ->columns([
                TextColumn::make('occurred_at')
                    ->label('Occurred')
                    ->formatStateUsing(fn (PlatformAuditLog $record): string => self::formatOccurredAt($record))
                    ->visibleFrom('md')
                    ->width('11rem')
                    ->grow(false)
                    ->sortable(),
                TextColumn::make('event_type')
                    ->label('Event')
                    ->searchable()
                    ->limit(75)
                    ->lineClamp(2)
                    ->wrap()
                    ->width('48%')
                    ->grow()
                    ->extraCellAttributes(['class' => 'break-words whitespace-normal'])
                    ->sortable(),
                TextColumn::make('actorUser.email')
                    ->label('Actor')
                    ->searchable()
                    ->placeholder('System')
                    ->visibleFrom('xl')
                    ->width('13rem')
                    ->grow(false)
                    ->toggleable(),
                TextColumn::make('result')
                    ->badge()
                    ->color(fn (?string $state): string => $state === 'success' ? 'success' : 'danger')
                    ->visibleFrom('sm')
                    ->width('6rem')
                    ->grow(false)
                    ->sortable(),
                TextColumn::make('severity')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'critical', 'error' => 'danger',
                        'warning' => 'warning',
                        default => 'info',
                    })
                    ->visibleFrom('xl')
                    ->width('6rem')
                    ->grow(false)
                    ->sortable(),
                TextColumn::make('route')
                    ->searchable()
                    ->limit(55)
                    ->wrap()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('request_id')
                    ->label('Request')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('result')
                    ->options([
                        'success' => 'Success',
                        'failure' => 'Failure',
                    ]),
                SelectFilter::make('severity')
                    ->options([
                        'debug' => 'Debug',
                        'info' => 'Info',
                        'notice' => 'Notice',
                        'warning' => 'Warning',
                        'error' => 'Error',
                        'critical' => 'Critical',
                    ]),
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
                    ->modalHeading(fn (PlatformAuditLog $record): string => 'Audit Log #'.$record->id)
                    ->modalWidth(Width::ThreeExtraLarge)
                    ->slideOver(),
            ])
            ->toolbarActions([]);
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('view-platform-audit-logs');
    }

    public static function canView(Model $record): bool
    {
        return Gate::allows('view-platform-audit-logs');
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
            'index' => ManagePlatformAuditLogs::route('/'),
        ];
    }

    private static function formatOccurredAt(PlatformAuditLog $record): string
    {
        return $record
            ->occurredAtForTimezone(auth()->user()?->timezone)
            ?->format('M j, Y g:i A T') ?? 'None';
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

    private static function limitText(?string $state, int $limit): string
    {
        return $state ? Str::limit($state, $limit) : 'None';
    }
}
