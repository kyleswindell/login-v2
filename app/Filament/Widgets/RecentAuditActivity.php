<?php

namespace App\Filament\Widgets;

use App\Models\PlatformAuditLog;
use App\Platform\Dashboard\RendersOnDashboard;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class RecentAuditActivity extends BaseWidget implements RendersOnDashboard
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 'full';

    public static function canView(): bool
    {
        return Auth::check() && Gate::allows('view-platform-audit-logs');
    }

    public function table(Table $table): Table
    {
        return $table
            ->heading('Recent Audit Activity')
            ->query(
                PlatformAuditLog::query()
                    ->latest('occurred_at')
                    ->limit(10),
            )
            ->paginated(false)
            ->columns([
                Tables\Columns\TextColumn::make('occurred_at')
                    ->label('When')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_type')
                    ->label('Type')
                    ->badge(),
                Tables\Columns\TextColumn::make('action')
                    ->label('Action')
                    ->limit(40),
                Tables\Columns\TextColumn::make('actor_user_id')
                    ->label('Actor')
                    ->formatStateUsing(fn ($state) => $state ?? '—'),
                Tables\Columns\TextColumn::make('result')
                    ->label('Result')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'success' => 'success',
                        'failure' => 'danger',
                        default   => 'gray',
                    }),
                Tables\Columns\TextColumn::make('severity')
                    ->label('Severity')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'critical' => 'danger',
                        'warning'  => 'warning',
                        'info'     => 'info',
                        default    => 'gray',
                    }),
            ]);
    }

    public function getDashboardView(): string
    {
        return 'livewire.platform.dashboard.widgets.recent-audit-activity';
    }

    public function getDashboardViewData(): array
    {
        return [
            'logs' => PlatformAuditLog::query()
                ->latest('occurred_at')
                ->limit(10)
                ->get(['occurred_at', 'event_type', 'action', 'actor_user_id', 'result', 'severity']),
        ];
    }
}
