<?php

namespace App\Filament\Resources\Clubs\ClubResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash; // PENTING: Untuk enkripsi password

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    protected static ?string $title = 'Daftar Pemain (Skuad)';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                // --- BAGIAN 1: DATA PROFIL ---
                Forms\Components\Section::make('Profil Pemain')
                    ->schema([
                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto Pemain')
                            ->disk('public')           // Simpan di storage/app/public
                            ->directory('players')     // Masuk subfolder players
                            ->visibility('public')     // Agar bisa dilihat browser
                            ->image()                  // Validasi gambar
                            ->imageEditor()            // Fitur crop/edit
                            // ->preserveFilenames()   // KITA HAPUS (Biarkan Laravel memberi nama acak agar upload aman)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Lengkap')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('number')
                            ->label('No. Punggung')
                            ->numeric()
                            ->maxValue(99)
                            ->required(),

                        Forms\Components\Select::make('position')
                            ->label('Posisi')
                            ->options([
                                'GK' => 'Goalkeeper (Kiper)',
                                'DF' => 'Defender (Bek)',
                                'MF' => 'Midfielder (Gelandang)',
                                'FW' => 'Forward (Penyerang)',
                            ])
                            ->required(),

                        Forms\Components\Toggle::make('is_captain')
                            ->label('Kapten Tim?')
                            ->inline(false),
                    ])->columns(2), // Tampilan 2 kolom

                // --- BAGIAN 2: AKUN LOGIN (BARU) ---
                Forms\Components\Section::make('Akun Portal Pemain')
                    ->description('Isi email & password jika pemain ini diizinkan login.')
                    ->schema([
                        Forms\Components\TextInput::make('email')
                            ->label('Email Login')
                            ->email()
                            ->unique(ignoreRecord: true) // Cek unik, tapi abaikan diri sendiri saat edit
                            ->maxLength(255),

                        Forms\Components\TextInput::make('password')
                            ->label('Kata Sandi')
                            ->password()
                            ->revealable() // Agar admin bisa intip password saat ketik
                            // HASHING OTOMATIS:
                            ->dehydrateStateUsing(fn ($state) => Hash::make($state))
                            // JANGAN UPDATE PASSWORD KALAU KOSONG (Saat Edit):
                            ->dehydrated(fn ($state) => filled($state))
                            // WAJIB DIISI HANYA SAAT CREATE (Bukan Edit):
                            ->required(fn (string $context): bool => $context === 'create'),
                    ])->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public') // Pastikan mengambil dari disk public
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),

                Tables\Columns\TextColumn::make('number')
                    ->label('#')
                    ->sortable()
                    ->weight('bold')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pemain')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn ($record) => $record->is_captain ? 'Kapten Tim ©' : null),

                Tables\Columns\TextColumn::make('position')
                    ->label('Pos')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'GK' => 'warning',
                        'DF' => 'info',
                        'MF' => 'success',
                        'FW' => 'danger',
                        default => 'gray',
                    }),
                    
                // Opsional: Tampilkan status punya akun atau tidak
                Tables\Columns\IconColumn::make('email')
                    ->label('Akun')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->getStateUsing(fn ($record) => !empty($record->email))
                    ->color(fn ($state) => $state ? 'success' : 'danger')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Pemain'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}