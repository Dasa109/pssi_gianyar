<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get; // <--- WAJIB IMPORT INI AGAR LOGIKA HIDE/SHOW JALAN
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

    // --- KEAMANAN: HANYA SUPER ADMIN YANG BISA LIHAT MENU INI ---
    public static function shouldRegisterNavigation(): bool
    {
        // Pastikan Model User sudah punya fungsi isSuperAdmin()
        return auth()->user()->isSuperAdmin();
    }

    public static function canViewAny(): bool
    {
        return auth()->user()->isSuperAdmin();
    }
    // ------------------------------------------------------------

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
                            // Cek unik kecuali user yang sedang diedit
                            ->unique(ignoreRecord: true) 
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->password()
                            // Hash password saat disimpan
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            // Hanya simpan jika password diisi (untuk edit)
                            ->dehydrated(fn ($state) => filled($state))
                            // Wajib diisi hanya saat create (edit boleh kosong)
                            ->required(fn (string $context): bool => $context === 'create'),

                        // --- PILIHAN ROLE ---
                        Forms\Components\Select::make('role')
                            ->label('Peran Akun')
                            ->options([
                                // GUNAKAN KEY 'super_admin' AGAR SESUAI DENGAN MODEL
                                'super_admin' => 'Super Admin (PSSI Pusat)', 
                                'operator'    => 'Operator Klub',
                            ])
                            ->default('operator')
                            ->required()
                            ->live(), // Live update agar form Klub di bawah bereaksi

                        // --- PILIHAN KLUB (Hanya muncul jika Operator) ---
                        Forms\Components\Select::make('club_id')
                            ->label('Pilih Klub yang Dikelola')
                            ->helperText('Wajib dipilih jika peran adalah Operator Klub')
                            ->relationship('club', 'name')
                            ->searchable()
                            ->preload()
                            // Gunakan class Get untuk membaca value 'role' diatas
                            ->required(fn (Get $get) => $get('role') === 'operator')
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
                        'super_admin' => 'danger',  // Merah untuk Admin
                        'operator'    => 'success', // Hijau untuk Operator
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'super_admin' => 'Super Admin',
                        'operator'    => 'Operator Klub',
                        default       => $state,
                    }),
                
                Tables\Columns\TextColumn::make('club.name')
                    ->label('Klub')
                    ->placeholder('-') // Strip jika dia admin pusat
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Cegah Admin menghapus dirinya sendiri
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