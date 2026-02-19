<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?string $navigationLabel = 'Manajemen User';
    
    protected static ?int $navigationSort = 1;

    // Hanya Super Admin yang bisa melihat menu ini
    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isSuperAdmin();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- Bagian Informasi Dasar ---
                TextInput::make('name')
                    ->label('Nama Lengkap')
                    ->required()
                    ->maxLength(255),

                TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true), // Cek unik kecuali punya sendiri saat edit

                // --- Bagian Role & Klub ---
                Select::make('role')
                    ->label('Role Akun')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'operator'    => 'Operator Klub',
                        // Tambahkan role lain sesuai kebutuhan
                    ])
                    ->required()
                    ->native(false), // Tampilan dropdown lebih modern

                Select::make('club_id')
                    ->relationship('club', 'name') // Pastikan relasi 'club' ada di Model User
                    ->label('Asal Klub')
                    ->searchable()
                    ->preload()
                    ->placeholder('Pilih Klub (Jika Operator)')
                    // Hanya wajib jika role bukan super_admin (opsional, sesuaikan kebutuhan)
                    ->visible(fn (Forms\Get $get) => $get('role') !== 'super_admin'),

                // --- Bagian Password ---
                TextInput::make('password')
                    ->password()
                    ->revealable()
                    ->label('Password')
                    // Wajib hanya saat Create
                    ->required(fn (string $operation): bool => $operation === 'create')
                    // Hash password sebelum simpan
                    ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                    // Jangan update field ini jika kosong saat Edit
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
                    ->icon('heroicon-m-envelope'),

                TextColumn::make('role')
                    ->badge()
                    ->label('Role')
                    ->color(fn (string $state): string => match ($state) {
                        'super_admin' => 'danger',
                        'operator'    => 'success',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'Super Admin',
                        'operator'    => 'Operator Klub',
                        default       => $state,
                    })
                    ->sortable(),

                TextColumn::make('club.name')
                    ->label('Klub')
                    ->placeholder('-')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                // Filter berdasarkan Role
                Tables\Filters\SelectFilter::make('role')
                    ->options([
                        'super_admin' => 'Super Admin',
                        'operator'    => 'Operator Klub',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                Tables\Actions\DeleteAction::make()
                    // Mencegah user menghapus dirinya sendiri
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
        return [
            //
        ];
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