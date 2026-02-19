<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set; // <--- WAJIB IMPORT 'Set' UNTUK MENGUBAH VALUE LAIN
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $navigationLabel = 'Manajemen User';

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pengguna')
                    ->description('Kelola akun untuk login ke sistem.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            ->dehydrated(fn ($state) => filled($state))
                            ->required(fn (string $context): bool => $context === 'create'),

                        // --- PILIHAN ROLE ---
                        Forms\Components\Select::make('role')
                            ->label('Peran Akun')
                            ->options([
                                'super_admin' => 'Admin',
                                'operator'    => 'Operator Klub',
                            ])
                            ->default('operator')
                            ->required()
                            ->live() // Aktifkan Live update
                            // --- LOGIKA PEMBERSIH ---
                            // Saat Role berubah, cek nilainya.
                            // Jika jadi 'super_admin', set 'club_id' jadi NULL.
                            ->afterStateUpdated(function (Set $set, ?string $state) {
                                if ($state === 'super_admin') {
                                    $set('club_id', null);
                                }
                            }),

                        // --- PILIHAN KLUB ---
                        Forms\Components\Select::make('club_id')
                            ->label('Pilih Klub yang Dikelola')
                            ->helperText('Wajib dipilih jika peran adalah Operator Klub')
                            ->relationship('club', 'name')
                            ->searchable()
                            ->preload()
                            ->required(fn (Get $get) => $get('role') === 'operator')
                            // Gunakan visible agar hilang total jika bukan operator
                            ->visible(fn (Get $get) => $get('role') === 'operator'),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->label('Role')
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'operator'    => 'success',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'Admin',
                        'operator'    => 'Operator Klub',
                        default       => $state,
                    }),

                Tables\Columns\TextColumn::make('club.name')
                    ->label('Klub')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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