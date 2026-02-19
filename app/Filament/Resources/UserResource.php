<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
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

                        // --- PILIHAN ROLE (ADMIN vs OPERATOR) ---
                        Forms\Components\Select::make('role')
                            ->label('Peran Akun')
                            ->options([
                                'super_admin' => 'Admin',          // Label Tampilan: Admin
                                'operator'    => 'Operator Klub',  // Label Tampilan: Operator
                            ])
                            ->default('operator')
                            ->required()
                            ->live()
                            // 1. PEMBERSIH UI: Saat diganti di layar, langsung kosongkan nilai club_id
                            ->afterStateUpdated(function (Set $set, $state) {
                                if ($state !== 'operator') {
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
                            ->visible(fn (Get $get) => $get('role') === 'operator')
                            ->required(fn (Get $get) => $get('role') === 'operator')
                            
                            // 2. PENJAGA DATABASE (PENTING!): 
                            // Saat tombol Simpan ditekan, sistem cek lagi:
                            // "Apakah role-nya Operator? Jika BUKAN, paksa club_id jadi NULL."
                            ->dehydrateStateUsing(fn ($state, Get $get) => $get('role') === 'operator' ? $state : null),
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
                        'super_admin' => 'Admin',        // Tampilan di Tabel
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