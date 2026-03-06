<?php

namespace App\Filament\Resources\Infractions;

use App\Filament\Resources\Infractions\Pages\CreateInfraction;
use App\Filament\Resources\Infractions\Pages\EditInfraction;
use App\Filament\Resources\Infractions\Pages\ListInfractions;
use App\Filament\Resources\Infractions\Pages\ViewInfraction;
use App\Filament\Resources\Infractions\Schemas\InfractionForm;
use App\Filament\Resources\Infractions\Schemas\InfractionInfolist;
use App\Filament\Resources\Infractions\Tables\InfractionsTable;
use App\Models\Infraction;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InfractionResource extends Resource
{
    protected static ?string $model = Infraction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Forms\Components\Select::make('fixture_id')
                ->label('Pertandingan')
                ->relationship('fixture', 'id')
                // Menampilkan nama tim agar tidak bingung input ID
                ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->homeTeam->name} vs {$record->awayTeam->name}")
                ->searchable()
                ->preload()
                ->required(),

            \Filament\Forms\Components\Select::make('customer_id')
                ->label('Pemain yang Melanggar')
                ->relationship('customer', 'name') // Sesuaikan 'name' atau 'nama'
                ->searchable()
                ->preload()
                ->required(),

            \Filament\Forms\Components\Select::make('card_type')
                ->label('Jenis Kartu')
                ->options([
                    'yellow' => 'Kuning',
                    'red' => 'Merah',
                ])
                ->required(),

            \Filament\Forms\Components\TextInput::make('minute')
                ->label('Menit Ke-')
                ->numeric()
                ->required(),

            \Filament\Forms\Components\Textarea::make('reason')
                ->label('Alasan Pelanggaran')
                ->required(),
        ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InfractionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InfractionsTable::configure($table);
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
            'index' => ListInfractions::route('/'),
            'create' => CreateInfraction::route('/create'),
            'view' => ViewInfraction::route('/{record}'),
            'edit' => EditInfraction::route('/{record}/edit'),
        ];
    }
}
