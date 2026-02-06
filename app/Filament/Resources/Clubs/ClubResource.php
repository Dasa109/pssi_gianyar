<?php

namespace App\Filament\Resources\Clubs;

use App\Filament\Resources\Clubs\Pages;
use App\Models\Club;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Illuminate\Support\Str;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    public static function getNavigationIcon(): ?string { return 'heroicon-o-shield-check'; }
    public static function getNavigationGroup(): ?string { return 'Master Data'; }
    public static function getNavigationLabel(): string { return 'Data Klub'; }
    public static function getModelLabel(): string { return 'Klub'; }
    
    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(\Filament\Forms\Form $form): \Filament\Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Identitas Klub')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Klub')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->unique(Club::class, 'slug', ignoreRecord: true),

                                Forms\Components\RichEditor::make('history')
                                    ->label('Sejarah & Profil')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Branding')
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo Klub')
                                    ->image()
                                    ->imageEditor()
                                    ->directory('clubs/logos')
                                    ->visibility('public')
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('short_name')
                                    ->label('Kode Singkatan')
                                    ->placeholder('PSD')
                                    ->maxLength(3)
                                    ->required()
                                    ->dehydrateStateUsing(fn (?string $state) => Str::upper($state))
                                    ->formatStateUsing(fn (?string $state) => Str::upper($state)),
                            ]),

                        Forms\Components\Section::make('Detail Lokasi')
                            ->schema([
                                // PERBAIKAN DI SINI: Ganti ->icon() jadi ->prefixIcon()
                                Forms\Components\TextInput::make('stadium_name')
                                    ->label('Stadion Homebase')
                                    ->prefixIcon('heroicon-m-map-pin'),
                                
                                Forms\Components\TextInput::make('phone')
                                    ->label('WhatsApp / Telp')
                                    ->tel()
                                    ->prefixIcon('heroicon-m-phone'),

                                Forms\Components\Textarea::make('address')
                                    ->label('Alamat Lengkap')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')), 

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Klub')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->description(fn (Club $record): string => $record->stadium_name ?? '-'),

                Tables\Columns\TextColumn::make('short_name')
                    ->label('Kode')
                    ->badge()
                    ->color('danger')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('phone')
                    ->label('Kontak')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClubs::route('/'),
            'create' => Pages\CreateClub::route('/create'),
            'edit' => Pages\EditClub::route('/{record}/edit'),
        ];
    }
}