<?php

namespace App\Filament\Pages;

use App\Filament\Pages\PemainDetail;
use App\Models\OfficialPemain;
use App\Models\PemainFormRegistration;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class DaftarPemain extends Page implements HasTable
{
    use InteractsWithTable;

    protected string $view = 'filament.pages.daftar-pemain';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::UserGroup;

    protected static UnitEnum|string|null $navigationGroup = 'Pemain';

    protected static ?string $navigationLabel = 'Daftar Pemain';

    public string $activeTab = 'official';

    public function updatedActiveTab(): void
    {
        $this->resetTable();
    }

    public function getStats(): array
    {
        return [
            'official' => OfficialPemain::count(),
            'pending' => PemainFormRegistration::where('status', 0)->count(),
            'rejected' => PemainFormRegistration::whereIn('status', [1, 2])->count(),
        ];
    }

    public function table(Table $table): Table
    {
        if ($this->activeTab === 'official') {
            $query = OfficialPemain::query();
        } elseif ($this->activeTab === 'pending') {
            $query = PemainFormRegistration::query()
                ->where('status', 0)
                ->with(['addedBy', 'club']);
        } else { // rejected
            $query = PemainFormRegistration::query()
                ->whereIn('status', [1, 2])
                ->with(['addedBy', 'club']);
        }

        return $table
            ->query($query)
            ->recordUrl(
                fn(Model $record): string =>
                $this->activeTab !== 'official'
                    ? EditPemain::getUrl(['record' => $record->id])
                    : '#'
            )
            ->columns($this->getColumnsForTab())
            ->defaultSort('created_at', 'desc');
    }

    protected function getColumnsForTab(): array
    {
        if ($this->activeTab === 'official') {
            return [
                TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('panggilan')
                    ->label('Panggilan')
                    ->searchable(),

                TextColumn::make('kewarganegaraan')
                    ->label('Kewarganegaraan')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('provinsi')
                    ->label('Provinsi')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('kota')
                    ->label('Kota')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('tinggi_badan')
                    ->label('TB (cm)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('berat_badan')
                    ->label('BB (kg)')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('no_hp')
                    ->label('No HP')
                    ->icon('heroicon-m-phone')
                    ->iconPosition(IconPosition::Before)
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-m-envelope')
                    ->iconPosition(IconPosition::Before)
                    ->toggleable(isToggledHiddenByDefault: true),
            ];
        } else {
            return [
                TextColumn::make('nama_lengkap')
                    ->label('Nama Pemain')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Tanggal Dikirim')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('updated_at')
                    ->label('Tanggal Diedit')
                    ->date('d M Y')
                    ->sortable(),


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

                TextColumn::make('keterangan')
                    ->label('Catatan')
                    ->limit(30)

            ];
        }
    }
}
