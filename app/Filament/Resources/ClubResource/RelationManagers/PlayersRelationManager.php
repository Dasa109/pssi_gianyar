<?php

namespace App\Filament\Resources\Clubs\ClubResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action; 
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    protected static ?string $title = 'Skuad & Pendaftar';

    // Icon pada Tab agar terlihat menarik
    protected static ?string $icon = 'heroicon-o-users';

    public function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')->required(),
            Forms\Components\TextInput::make('email')->email()->required(),
            // Tambah input password (hanya saat create)
            Forms\Components\TextInput::make('password')
                ->password()
                ->visibleOn('create') // Hanya muncul saat buat baru
                ->required(),
            Forms\Components\Select::make('position')
                ->options([
                    'GK' => 'Kiper', 'DEF' => 'Bek', 'MID' => 'Gelandang', 'FWD' => 'Penyerang'
                ]),
            // Opsi status agar admin bisa langsung set 'Active'
            Forms\Components\Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'active' => 'Active',
                    'rejected' => 'Rejected',
                ])
                ->default('active') // Default langsung aktif kalau admin yang input
                ->required(),
        ]);
}

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            // INTEGRASI: Urutkan agar yang 'pending' muncul paling atas
            ->defaultSort('status', 'desc') 
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pemain')
                    ->searchable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('position')
                    ->label('Posisi')
                    ->badge(),

                // INTEGRASI: Badge Status Visual
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',  // Kuning (Perlu Tindakan)
                        'active' => 'success',   // Hijau (Aman)
                        'rejected' => 'danger',  // Merah (Ditolak)
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Menunggu Persetujuan',
                        'active' => 'Resmi',
                        'rejected' => 'Ditolak',
                        default => $state,
                    })
                    ->icon(fn (string $state): string => match ($state) {
                        'pending' => 'heroicon-m-clock',
                        'active' => 'heroicon-m-check-badge',
                        'rejected' => 'heroicon-m-x-circle',
                        default => 'heroicon-m-question-mark-circle',
                    }),
            ])
            ->filters([
                // Filter Cepat untuk Manajer
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Menunggu Approval',
                        'active' => 'Skuad Resmi',
                        'rejected' => 'Ditolak',
                    ])
                    ->label('Filter Status'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->label('Tambah Pemain Manual'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                
                // --- INTEGRASI: TOMBOL TERIMA ---
                Action::make('approve')
                    ->label('Terima Masuk Skuad')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->button() // Tampil sebagai tombol, bukan link
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->modalHeading('Terima Pemain ini?')
                    ->modalDescription('Pemain akan resmi masuk ke dalam skuad dan bisa login ke portal.')
                    ->action(function ($record) {
                        $record->update(['status' => 'active']);
                        
                        Notification::make()
                            ->title('Berhasil')
                            ->body("{$record->name} resmi diterima.")
                            ->success()
                            ->send();
                    }),

                // --- INTEGRASI: TOMBOL TOLAK ---
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-mark')
                    ->color('danger')
                    ->visible(fn ($record) => $record->status === 'pending')
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['status' => 'rejected'])),
            ]);
    }
}