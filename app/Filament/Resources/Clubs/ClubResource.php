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
        // Tampilkan jumlah klub yang statusnya pending untuk Admin
        if (auth()->user() && auth()->user()->isSuperAdmin()) {
            return static::getModel()::where('status', 'pending')->count();
        }
        return static::getEloquentQuery()->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getNavigationBadge() > 0 ? 'warning' : 'primary';
    }

    public static function form(Form $form): Form
    {
        $isOperator = auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && !auth()->user()->isSuperAdmin();
        $isSuperAdmin = auth()->user() && method_exists(auth()->user(), 'isSuperAdmin') && auth()->user()->isSuperAdmin();

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

                                Forms\Components\Select::make('status')
                                    ->label('Status Validasi')
                                    ->options([
                                        'pending' => 'Menunggu Persetujuan',
                                        'approved' => 'Disetujui / Aktif',
                                        'rejected' => 'Ditolak',
                                    ])
                                    ->default('approved')
                                    ->required()
                                    ->disabled($isOperator) // Hanya admin yang bisa ubah status
                                    ->visible($isSuperAdmin),

                                Forms\Components\RichEditor::make('history')
                                    ->label('Sejarah & Profil')
                                    ->toolbarButtons(['bold', 'italic', 'link', 'bulletList'])
                                    ->columnSpanFull()
                                    // Boleh kosong saat mendaftar dari React
                                    ->required(false), 
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Logo & Legalitas')
                            ->schema([
                                Forms\Components\FileUpload::make('logo')
                                    ->label('Logo Klub')
                                    ->image()
                                    ->disk('public')
                                    ->directory('clubs/logos')
                                    ->imageEditor()
                                    ->columnSpanFull(),

                                Forms\Components\FileUpload::make('legal_document')
                                    ->label('Dokumen Legalitas (PDF/ZIP)')
                                    ->acceptedFileTypes(['application/pdf', 'application/zip'])
                                    ->disk('public')
                                    ->directory('clubs/documents')
                                    ->columnSpanFull()
                                    ->visible($isSuperAdmin), // Operator tidak perlu lihat ini saat edit

                                Forms\Components\TextInput::make('short_name')
                                    ->label('Kode / Singkatan')
                                    ->placeholder('PSG')
                                    ->maxLength(5)
                                    // Boleh kosong saat dari React, admin nanti yang isi
                                    ->required(false) 
                                    ->live()
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('short_name', Str::upper($state))),
                            ]),

                        Forms\Components\Section::make('Detail Lokasi')
                            ->schema([
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

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Aktif',
                        'rejected' => 'Ditolak',
                    }),

                Tables\Columns\TextColumn::make('short_name')
                    ->label('Kode')
                    ->badge()
                    ->color('primary')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('legal_document')
                    ->label('Berkas')
                    ->formatStateUsing(fn ($state) => $state ? 'Unduh' : '-')
                    ->url(fn ($record) => $record->legal_document ? asset('storage/'.$record->legal_document) : null)
                    ->openUrlInNewTab()
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('info')
                    ->visible($isSuperAdmin),

                Tables\Columns\TextColumn::make('players_count')
                    ->label('Jml Pemain')
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'gray'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Aktif',
                        'rejected' => 'Ditolak',
                    ])
                    ->visible($isSuperAdmin),
            ])
            ->actions([
                // Tombol Approve untuk Admin
                Tables\Actions\Action::make('approve')
                    ->label('Terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (Club $record) => $isSuperAdmin && $record->status === 'pending')
                    ->action(fn (Club $record) => $record->update(['status' => 'approved'])),

                // Tombol Reject untuk Admin
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn (Club $record) => $isSuperAdmin && $record->status === 'pending')
                    ->action(fn (Club $record) => $record->update(['status' => 'rejected'])),

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