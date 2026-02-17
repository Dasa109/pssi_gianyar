<?php

namespace App\Filament\Resources\Clubs;

use App\Filament\Resources\Clubs\Pages;
use App\Models\Club;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\Clubs\ClubResource\RelationManagers\PlayersRelationManager;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'Master Data';
    protected static ?string $navigationLabel = 'Data Klub';
    protected static ?string $modelLabel = 'Klub';
    protected static ?int $navigationSort = 1;

    /**
     * LOGIC 1: GLOBAL FILTER
     * Memastikan Operator hanya melihat klub mereka sendiri.
     */
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $user = auth()->user();

        if ($user && method_exists($user, 'isSuperAdmin') && !$user->isSuperAdmin()) {
            $query->where('id', $user->club_id);
        }

        return $query;
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getEloquentQuery()->count();
    }

    public static function form(Form $form): Form
    {
        $isOperator = auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && !auth()->user()->isSuperAdmin();

        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Identitas Klub')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Nama Klub')
                                    ->required()
                                    ->placeholder('Contoh: PS Gianyar')
                                    ->disabled($isOperator) 
                                    ->dehydrated() 
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->unique(Club::class, 'slug', ignoreRecord: true)
                                    ->required(),

                                // PERBAIKAN: Pastikan menggunakan 'history' sesuai migrasi terbaru
                                Forms\Components\RichEditor::make('history')
                                    ->label('Sejarah & Profil')
                                    ->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])
                                    ->columnSpanFull()
                                    ->required(), // Tambahkan required agar data tidak kosong
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Logo & Branding')
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo Klub')
                                    ->image()
                                    ->disk('public')
                                    ->directory('clubs/logos')
                                    ->imageEditor()
                                    ->columnSpanFull(),

                                Forms\Components\TextInput::make('short_name')
                                    ->label('Kode / Singkatan')
                                    ->placeholder('PSG')
                                    ->maxLength(5)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('short_name', Str::upper($state))),
                            ]),

                        Forms\Components\Section::make('Detail Lokasi')
                            ->schema([
                                // Pastikan nama field ini sama dengan di Model dan Migration
                                Forms\Components\TextInput::make('stadium')
                                    ->label('Stadion Homebase')
                                    ->prefixIcon('heroicon-m-map-pin'),

                                Forms\Components\TextInput::make('phone')
                                    ->label('Kontak Official')
                                    ->tel()
                                    ->prefixIcon('heroicon-m-phone'),

                                Forms\Components\Textarea::make('address')
                                    ->label('Alamat Sekretariat')
                                    ->rows(2),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        $isSuperAdmin = auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin();

        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('players'))
            ->columns([
                Tables\Columns\ImageColumn::make('logo')
                    ->label('Logo')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Klub')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('short_name')
                    ->label('Kode')
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('players_count')
                    ->label('Jml Pemain')
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible($isSuperAdmin),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible($isSuperAdmin),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            PlayersRelationManager::class,
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin();
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