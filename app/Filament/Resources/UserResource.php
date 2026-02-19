<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Model;

class UserResource extends Resource
{
    protected static ?string $model = User::class;
    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Manajemen User';

    /**
     * KEAMANAN URL: Mencegah akses Edit via URL jika targetnya adalah Super Admin lain
     */
    public static function canEdit(Model $record): bool
    {
        // Izinkan edit jika: Target bukan Super Admin ATAU Target adalah diri sendiri
        return $record->role !== 'super_admin' || $record->id === auth()->id();
    }

    /**
     * KEAMANAN URL: Mencegah akses Delete via URL/API jika targetnya adalah diri sendiri atau Super Admin
     */
    public static function canDelete(Model $record): bool
    {
        return $record->role !== 'super_admin' && $record->id !== auth()->id();
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),

                Select::make('role')
                    ->label('Role Akun')
                    ->options([
                        'admin'       => 'Admin',
                        'operator'    => 'Operator Klub',
                    ])
                    ->required()
                    ->native(false)
                    ->live()
                    // PROTEKSI: Jika user ini adalah Super Admin, Role tidak bisa diubah (biar tidak downgrade)
                    ->disabled(fn (?User $record) => $record?->role === 'super_admin')
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        if ($state !== 'operator') {
                            $set('club_id', null);
                        }
                    }),

                Select::make('club_id')
                    ->relationship('club', 'name')
                    ->label('Asal Klub')
                    ->searchable()
                    ->preload()
                    ->visible(fn (Get $get) => $get('role') === 'operator')
                    ->required(fn (Get $get) => $get('role') === 'operator'),

                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->label('Password')
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    ->dehydrated(fn (?string $state): bool => filled($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->icon('heroicon-m-envelope'),
                
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'admin'       => 'warning',
                        'operator'    => 'success',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'Super Admin',
                        'admin'       => 'Admin',
                        'operator'    => 'Operator Klub',
                        default       => $state,
                    }),

                TextColumn::make('club.name')
                    ->label('Klub')
                    ->placeholder('-')
                    ->state(function (User $record) {
                        return ($record->role === 'super_admin' || $record->role === 'admin') 
                            ? null 
                            : $record->club?->name;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}