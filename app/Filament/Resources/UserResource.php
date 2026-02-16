<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get; // <--- WAJIB IMPORT INI
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Settings';

    // --- KEAMANAN 1: SEMBUNYIKAN MENU DARI OPERATOR ---
    // Hanya Super Admin yang boleh melihat menu "Users"
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    // Cegah akses langsung via URL jika bukan Super Admin
    public static function canViewAny(): bool
    {
        return auth()->user()->isSuperAdmin();
    }
    // --------------------------------------------------

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Pengguna')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            // --- PERBAIKAN: CEK EMAIL UNIK ---
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
                                'admin' => 'Super Admin (PSSI Pusat)',
                                'operator' => 'Operator Klub',
                            ])
                            ->default('operator')
                            ->required()
                            ->live(), // Live update agar form bawah bereaksi

                        // --- PILIHAN KLUB ---
                        Forms\Components\Select::make('club_id')
                            ->label('Pilih Klub yang Dikelola')
                            ->helperText('Wajib dipilih jika peran adalah Operator Klub')
                            ->relationship('club', 'name')
                            ->searchable()
                            ->preload()
                            // Gunakan class Get yang sudah diimport di atas
                            ->required(fn (Get $get) => $get('role') === 'operator')
                            ->hidden(fn (Get $get) => $get('role') !== 'operator'),
                    ])
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
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'admin' => 'danger',
                        'operator' => 'success',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'admin' => 'Super Admin',
                        'operator' => 'Operator Klub',
                        default => $state,
                    }),
                    
                Tables\Columns\TextColumn::make('club.name')
                    ->label('Klub')
                    ->placeholder('-') // Strip jika dia admin pusat
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Opsional: Admin tidak bisa hapus dirinya sendiri
                Tables\Actions\DeleteAction::make()
                    ->hidden(fn (User $record) => $record->id === auth()->id()),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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