<?php

namespace App\Filament\Resources\PlatformUsers;

use App\Filament\Resources\PlatformUsers\Pages\ManagePlatformUsers;
use App\Models\User;
use App\Support\InternalPhoneFormatter;
use BackedEnum;
use Filament\Actions\EditAction;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use UnitEnum;

class PlatformUserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;

    protected static string|UnitEnum|null $navigationGroup = 'Administration';

    protected static ?string $navigationLabel = 'Platform Users';

    protected static ?string $modelLabel = 'Platform User';

    protected static ?string $pluralModelLabel = 'Platform Users';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make('Identity')
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->rules([Password::defaults()], fn (?string $state): bool => filled($state))
                            ->dehydrated(fn (?string $state): bool => filled($state)),
                    ])
                    ->columns([
                        'md' => 2,
                    ]),
                Section::make('Staff Profile')
                    ->schema([
                        TextInput::make('hourly_rate')
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(999999.99),
                        TextInput::make('phone')
                            ->maxLength(50)
                            ->extraInputAttributes([
                                'data-ui-phone-input' => 'true',
                                'inputmode' => 'tel',
                                'autocomplete' => 'tel',
                                'placeholder' => '(555) 555-5555',
                            ]),
                        TextInput::make('facebook')
                            ->maxLength(255),
                        TextInput::make('linkedin')
                            ->maxLength(255),
                        TextInput::make('skype')
                            ->maxLength(255),
                        TextInput::make('default_language')
                            ->maxLength(10),
                        Select::make('direction')
                            ->options([
                                'ltr' => 'Left to right',
                                'rtl' => 'Right to left',
                            ])
                            ->default('ltr'),
                        Textarea::make('email_signature')
                            ->maxLength(5000)
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'md' => 2,
                    ]),
                Section::make('Access')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                        Toggle::make('send_welcome_email')
                            ->label('Send welcome email'),
                        Toggle::make('is_administrator')
                            ->label('Administrator'),
                        Toggle::make('is_staff_member')
                            ->label('Staff member')
                            ->default(true),
                        CheckboxList::make('roles')
                            ->options(fn (): array => Role::query()
                                ->orderBy('name')
                                ->pluck('name', 'name')
                                ->all())
                            ->columns([
                                'md' => 2,
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns([
                        'md' => 2,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->defaultSort('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->separator(', ')
                    ->placeholder('No roles'),
                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('last_login_at')
                    ->label('Last login')
                    ->dateTime('M j, Y g:i A')
                    ->placeholder('Never')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (($data['value'] ?? null) === null || $data['value'] === '') {
                            return $query;
                        }

                        return $query->where('is_active', $data['value'] === '1');
                    }),
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make()
                    ->mutateRecordDataUsing(fn (array $data, User $record): array => [
                        ...$data,
                        'roles' => $record->roles()->pluck('name')->all(),
                    ])
                    ->using(function (User $record, array $data): User {
                        $roles = Arr::pull($data, 'roles', []);
                        $record->fill(self::normalizeUserData($data, false));
                        $record->save();
                        $record->syncRoles($roles);

                        return $record;
                    }),
            ])
            ->toolbarActions([]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('roles');
    }

    public static function canViewAny(): bool
    {
        return Gate::allows('manage-platform-users');
    }

    public static function canCreate(): bool
    {
        return Gate::allows('manage-platform-users');
    }

    public static function canEdit(Model $record): bool
    {
        return Gate::allows('manage-platform-users');
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
            'index' => ManagePlatformUsers::route('/'),
        ];
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function normalizeUserData(array $data, bool $isCreate): array
    {
        $data['name'] = trim(($data['first_name'] ?? '').' '.($data['last_name'] ?? ''));
        $data['hourly_rate'] = (float) ($data['hourly_rate'] ?? 0);
        $data['phone'] = InternalPhoneFormatter::normalize($data['phone'] ?? null);
        $data['direction'] = $data['direction'] ?? 'ltr';
        $data['send_welcome_email'] = (bool) ($data['send_welcome_email'] ?? false);
        $data['is_administrator'] = (bool) ($data['is_administrator'] ?? false);
        $data['is_staff_member'] = (bool) ($data['is_staff_member'] ?? true);

        if (filled($data['password'] ?? null)) {
            $data['password'] = Hash::make((string) $data['password']);
        } else {
            Arr::forget($data, 'password');
        }

        if ($isCreate) {
            $data['is_active'] = (bool) ($data['is_active'] ?? true);
        } else {
            $data['is_active'] = (bool) ($data['is_active'] ?? false);
        }

        return $data;
    }
}
