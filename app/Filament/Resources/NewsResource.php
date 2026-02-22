<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsResource\Pages;
use App\Models\News;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    // Ikon koran agar pas dengan tema berita
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Publikasi';
    protected static ?string $navigationLabel = 'Berita & Info';
    protected static ?string $modelLabel = 'Berita';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // KOLOM KIRI: Konten Utama (Lebih Lebar)
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Konten Berita')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul Berita')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                                Forms\Components\TextInput::make('slug')
                                    ->label('URL Slug')
                                    ->disabled()
                                    ->dehydrated()
                                    ->required()
                                    ->unique(News::class, 'slug', ignoreRecord: true),

                                Forms\Components\Select::make('category')
                                    ->label('Kategori')
                                    ->options([
                                        'Regulasi' => 'Regulasi',
                                        'Matchday' => 'Matchday (Pertandingan)',
                                        'Transfer' => 'Bursa Transfer',
                                        'Umum' => 'Informasi Umum',
                                    ])
                                    ->default('Umum')
                                    ->required(),

                                Forms\Components\RichEditor::make('content')
                                    ->label('Isi Berita')
                                    ->required()
                                    ->toolbarButtons([
                                        'attachFiles', 'blockquote', 'bold', 'bulletList', 
                                        'h2', 'h3', 'italic', 'link', 'orderedList', 
                                        'redo', 'strike', 'underline', 'undo',
                                    ])
                                    ->fileAttachmentsDisk('public')
                                    ->fileAttachmentsDirectory('news/attachments')
                                    ->columnSpanFull(),
                            ])->columns(2),
                    ])->columnSpan(['lg' => 2]),

                // KOLOM KANAN: Pengaturan Publish & Media
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status Penayangan')
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->label('Status Berita')
                                    ->options([
                                        'draft' => 'Draf (Simpan Saja)',
                                        'published' => 'Publish (Tayangkan)',
                                    ])
                                    ->default('draft')
                                    ->required(),

                                Forms\Components\DateTimePicker::make('published_at')
                                    ->label('Tanggal Tayang')
                                    ->default(now())
                                    ->required(),
                            ]),

                        Forms\Components\Section::make('Media & Peringatan')
                            ->schema([
                                Forms\Components\FileUpload::make('thumbnail')
                                    ->label('Gambar Cover (Thumbnail)')
                                    ->image()
                                    ->disk('public')
                                    ->directory('news/thumbnails')
                                    ->imageEditor(),

                                Forms\Components\Toggle::make('is_emergency')
                                    ->label('Jadikan Peringatan Darurat')
                                    ->helperText('Jika aktif, berita ini akan muncul sebagai pita merah di atas halaman depan (Cocok untuk info force majeure/bencana).')
                                    ->onColor('danger')
                                    ->offColor('gray')
                                    ->default(false),
                            ]),
                    ])->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->label('Cover')
                    ->circular()
                    ->defaultImageUrl(url('/images/placeholder.png')),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Berita')
                    ->searchable()
                    ->sortable()
                    ->limit(40) // Batasi teks agar tabel tidak kepanjangan
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->searchable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'published' => 'success',
                    }),

                Tables\Columns\IconColumn::make('is_emergency')
                    ->label('Darurat')
                    ->boolean()
                    ->trueIcon('heroicon-o-exclamation-triangle')
                    ->trueColor('danger')
                    ->falseIcon('heroicon-o-minus')
                    ->falseColor('gray'),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tgl Tayang')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draf',
                        'published' => 'Tayang',
                    ]),
                Tables\Filters\TernaryFilter::make('is_emergency')
                    ->label('Info Darurat'),
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

    // LOGIKA KEAMANAN: Hanya Super Admin & Admin yang bisa akses
    public static function canAccess(): bool
    {
        $user = auth()->user();
        return $user && method_exists($user, 'isSuperAdmin') && ($user->isSuperAdmin() || $user->isAdmin());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNews::route('/'),
            'create' => Pages\CreateNews::route('/create'),
            'edit' => Pages\EditNews::route('/{record}/edit'),
        ];
    }
}