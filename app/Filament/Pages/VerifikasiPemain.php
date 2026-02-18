<?php

namespace App\Filament\Pages;

use App\Filament\Pages\PemainDetail;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class VerifikasiPemain extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.verifikasi-pemain';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::CheckCircle;
    protected static string|UnitEnum|null $navigationGroup = 'Pemain';
    protected static ?string $navigationLabel = 'Verifikasi Pemain';

    public function table(Table $table): Table
    {
        return $table
            ->query(\App\Models\PemainFormRegistration::query()->where("status", "!=", 3)->with(['addedBy', 'club']))
            ->recordUrl(fn(Model $record): string => PemainDetail::getUrl([
                'record' => $record->id,
            ]))
            ->columns([
                TextColumn::make('nama_lengkap')->searchable()->label("Nama Pemain"),
                TextColumn::make('club.name'),
                TextColumn::make('created_at')->date('Y-m-d')->label("Dikirim Pada"),
                TextColumn::make('updated_at')->date('Y-m-d')->label("Diupdate Pada"),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn(int $state): string => match ($state) {
                        0 => 'gray',
                        1 => 'warning',
                        2 => 'danger',
                        3 => 'success',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn(int $state): string => match ($state) {
                        0 => 'Belum Diverifikasi',
                        1 => 'Kurang',
                        2 => 'Tidak Lengkap',
                        3 => 'Sah',
                        default => 'Unknown',
                    })
                    ->sortable(),
                TextColumn::make('keterangan'),
            ]);
    }
}
