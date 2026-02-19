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

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Manajemen User';
    protected static ?int $navigationSort = 1;

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

                // --- BAGIAN ROLE YANG DIPERBAIKI ---
                Select::make('role')
                    ->label('Role Akun')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'admin'       => 'Admin',        // <--- Role Admin ditambahkan
                        'operator'    => 'Operator Klub',
                    ])
                    ->required()
                    ->native(false)
                    ->live() // <--- Agar form bereaksi langsung saat ini diganti
                    ->afterStateUpdated(function (Set $set, ?string $state) {
                        // Jika role bukan operator, hapus pilihan klub
                        if ($state !== 'operator') {
                            $set('club_id', null);
                        }
                    }),

                // --- BAGIAN KLUB YANG DIPERBAIKI ---
                Select::make('club_id')
                    ->relationship('club', 'name')
                    ->label('Asal Klub')
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih Klub')
                    // Hanya muncul jika role yang dipilih adalah 'operator'
                    ->visible(fn (Get $get) => $get('role') === 'operator')
                    // Wajib diisi HANYA jika terlihat (yaitu saat jadi operator)
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
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->searchable()
                    ->icon('heroicon-m-envelope')
                    ->copyable(),

                TextColumn::make('role')
                    ->badge()
                    ->label('Role')
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',   // Merah
                        'admin'       => 'warning',  // Kuning/Oranye
                        'operator'    => 'success',  // Hijau
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'Super Admin',
                        'admin'       => 'Admin',
                        'operator'    => 'Operator Klub',
                        default       => $state,
                    })
                    ->sortable(),

                // --- BAGIAN KLUB DI TABEL ---
                TextColumn::make('club.name')
                    ->label('Klub')
                    ->placeholder('-')
                    // Paksa tampil '-' jika usernya Admin/Super Admin (meski di DB masih ada datanya)
                    ->state(function (User $record) {
                        if ($record->role === 'super_admin' || $record->role === 'admin') {
                            return null;
                        }
                        return $record->club?->name;
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'admin'       => 'Admin',
                        'operator'    => 'Operator Klub',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn (User $record) => $record->id === auth()->id()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
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