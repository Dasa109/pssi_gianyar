<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlayerResource\Pages;
use App\Models\Player;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\IconColumn;
use Illuminate\Support\Facades\Hash;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    
    protected static ?string $navigationGroup = 'Master Data';
    
    protected static ?string $navigationLabel = 'Data Pemain';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Akun')
                    ->description('Data login untuk pemain jika memiliki akses aplikasi')
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
                            
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->required(fn (string $operation): bool => $operation === 'create'),
                    ])->columns(2),

                Section::make('Detail Karir & Klub')
                    ->schema([
                        Select::make('club_id')
                            ->relationship('club', 'name')
                            ->label('Klub Resmi')
                            ->searchable()
                            ->preload()
                            ->placeholder('Pilih Klub (Jika terdaftar)'),
                            
                        TextInput::make('club_dummy')
                            ->label('Klub Alternatif (Dummy)')
                            ->placeholder('Isi jika tidak ada di daftar klub resmi')
                            ->maxLength(255),

                        Select::make('position')
                            ->label('Posisi Bermain')
                            ->options([
                                'GK' => 'Goalkeeper (GK)',
                                'CB' => 'Center Back (CB)',
                                'LB' => 'Left Back (LB)',
                                'RB' => 'Right Back (RB)',
                                'DMF' => 'Defensive Midfielder (DMF)',
                                'CMF' => 'Central Midfielder (CMF)',
                                'AMF' => 'Attacking Midfielder (AMF)',
                                'LWF' => 'Left Winger (LWF)',
                                'RWF' => 'Right Winger (RWF)',
                                'CF' => 'Center Forward (CF)',
                            ])
                            ->searchable(),

                        TextInput::make('number')
                            ->label('Nomor Punggung')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(99),

                        Toggle::make('is_captain')
                            ->label('Status Kapten Tim')
                            ->inline(false),

                        Select::make('status')
                            ->label('Status Pemain')
                            ->options([
                                'active' => 'Aktif Bermain',
                                'injured' => 'Cedera',
                                'suspended' => 'Diskorsing',
                                'inactive' => 'Tidak Aktif',
                            ])
                            ->default('active')
                            ->required(),
                    ])->columns(2),

                Section::make('Media')
                    ->schema([
                        FileUpload::make('photo')
                            ->label('Foto Pemain')
                            ->image()
                            ->directory('players-photos')
                            ->maxSize(2048), // Maksimal 2MB
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-avatar.png')), // Opsional jika belum ada foto

                TextColumn::make('name')
                    ->label('Nama Pemain')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('position')
                    ->label('Posisi')
                    ->badge()
                    ->searchable(),

                TextColumn::make('number')
                    ->label('No. Punggung')
                    ->sortable(),

                TextColumn::make('club.name')
                    ->label('Klub')
                    ->placeholder('-')
                    ->sortable(),

                IconColumn::make('is_captain')
                    ->label('Kapten')
                    ->boolean()
                    ->trueIcon('heroicon-o-star')
                    ->falseIcon('heroicon-o-minus'),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'injured' => 'warning',
                        'suspended' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Aktif',
                        'injured' => 'Cedera',
                        'suspended' => 'Diskors',
                        'inactive' => 'Tidak Aktif',
                        default => $state,
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('club_id')
                    ->relationship('club', 'name')
                    ->label('Filter Klub'),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Aktif',
                        'injured' => 'Cedera',
                        'suspended' => 'Diskorsing',
                        'inactive' => 'Tidak Aktif',
                    ]),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlayers::route('/'),
            'create' => Pages\CreatePlayer::route('/create'),
            'edit' => Pages\EditPlayer::route('/{record}/edit'),
        ];
    }
}