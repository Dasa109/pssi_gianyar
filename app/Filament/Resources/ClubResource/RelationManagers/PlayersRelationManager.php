<?php

namespace App\Filament\Resources\Clubs\ClubResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PlayersRelationManager extends RelationManager
{
    protected static string $relationship = 'players';

    protected static ?string $title = 'Daftar Pemain (Skuad)';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('photo')
    ->label('Foto Pemain')
    ->disk('public')           // Tetap pakai ini
    ->directory('players')     // Masuk folder players
    ->visibility('public')
    ->image()                  // Nyalakan lagi (karena di Club bisa)
    ->imageEditor()            // Nyalakan lagi (karena di Club bisa)
    // ->preserveFilenames()   <-- HAPUS BARIS INI! (Biarkan Laravel memberi nama acak/hash)
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