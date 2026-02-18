<?php

namespace App\Filament\Pages;

use App\Models\OfficialPemain;
use App\Models\PemainFormRegistration;
use App\Models\User;
use BackedEnum;
use Carbon\Carbon;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Actions;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Filament\Schemas\Components\Utilities\Set;


class EditPemain extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.pemain-detail';

    protected static bool $shouldRegisterNavigation = false;
    public ?PemainFormRegistration $formPemain = null;
    public ?array $data = [];
    public array $countries = [];
    public array $provinces = [];

    protected function loadCountries(): void
    {
        if (!empty($this->countries)) {
            return;
        }

        try {
            $country_raw = Http::get("https://www.apicountries.com/countries")->json();
            foreach ($country_raw as $country) {
                $this->countries[$country["name"]] = $country["name"];
            }
        } catch (\Throwable $e) {
            // silent fail
        }
    }

    protected function loadProvinces(): void
    {
        if (!empty($this->provinces)) {
            return;
        }

        try {
            $province_raw = Http::get("https://wilayah.id/api/provinces.json")->json();
            foreach ($province_raw["data"] as $province) {
                $this->provinces[$province["code"]] = $province["name"];
            }
        } catch (\Throwable $e) {
            // silent fail
        }
    }


    public function mount(): void
    {
        $selected_id = (int) request()->query('record');
        $this->formPemain = PemainFormRegistration::where("id", $selected_id)
            ->firstOrFail();

        $this->loadCountries();
        $this->loadProvinces();

        $data_lain = $this->formPemain->toArray();
        $this->form->fill($data_lain);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([

                Section::make('Data Pribadi')
                    ->description('Informasi identitas pemain')
                    ->icon(Heroicon::User)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nama_lengkap')->label('Nama Lengkap'),
                            TextInput::make('panggilan')->label('Panggilan'),

                            DatePicker::make('tanggal_lahir')
                                ->label('Tanggal Lahir')
                                ->native(false)
                                ->suffixIcon(Heroicon::Calendar),

                            TextInput::make('no_id')->label('No Identitas'),

                            Select::make('jenis_id')
                                ->label('Jenis Identitas')
                                ->options([
                                    'nik' => 'NIK',
                                    'pasport' => 'Pasport',
                                    'kia' => 'KIA',
                                ])
                                ->native(false),

                            Select::make('kewarganegaraan')
                                ->label('Kewarganegaraan')
                                ->options(fn() => $this->countries)
                                ->searchable()
                                ->native(false)
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('provinsi', null);
                                    $set('kota', null);
                                }),

                            Select::make('provinsi')
                                ->label('Provinsi')
                                ->options(fn() => $this->provinces)
                                ->searchable()
                                ->native(false)
                                ->live()
                                ->afterStateUpdated(fn(Set $set) => $set('kota', null))
                                ->disabled(fn(Get $get) => $get('kewarganegaraan') !== 'Indonesia'),

                            Select::make('kota')
                                ->label('Kota')
                                ->options(function (Get $get) {
                                    $provinceCode = $get('provinsi');

                                    if (!$provinceCode) {
                                        return [];
                                    }

                                    try {
                                        $city_raw = Http::get("https://wilayah.id/api/regencies/{$provinceCode}.json")->json();
                                        $cities = [];

                                        foreach ($city_raw["data"] as $city) {
                                            $cities[$city["name"]] = $city["name"];
                                        }

                                        return $cities;
                                    } catch (\Throwable $e) {
                                        return [];
                                    }
                                })
                                ->searchable()
                                ->native(false)
                                ->disabled(
                                    fn(Get $get) =>
                                    $get('kewarganegaraan') !== 'Indonesia' || !$get('provinsi')
                                ),

                            TextInput::make('tinggi_badan')
                                ->label('Tinggi Badan')
                                ->suffix('cm')
                                ->numeric(),

                            TextInput::make('berat_badan')
                                ->label('Berat Badan')
                                ->suffix('kg')
                                ->numeric(),

                            TextInput::make('no_hp')->label('No HP')->prefix('+'),
                            TextInput::make('email')->label('Email'),
                        ]),

                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(3)

                            ->columnSpanFull(),
                    ])
                    ->columns(1),

                Section::make('Dokumen')
                    ->description('File yang diunggah pemain')
                    ->icon(Heroicon::Document)
                    ->schema([
                        Grid::make(3)->schema([
                            FileUpload::make('ijazah_file_path')
                                ->label("File Ijazah")
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory("ijazah"),

                            FileUpload::make('akta_file_path')
                                ->label("File Akta Kelahiran")
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory("akta"),

                            FileUpload::make('kartu_kelahiran_file_path')
                                ->label("File Kartu Kelahiran")
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory("kartu_kelahiran"),

                            FileUpload::make('identitas_file_path')
                                ->label("Foto Kartu Identitas KTP/KIA")
                                ->image()
                                ->minSize(10)
                                ->maxSize(20000)
                                ->required()
                                ->directory("identitas"),

                            FileUpload::make('surat_kerjasama_file_path')
                                ->label("Surat Kerjasama")
                                ->acceptedFileTypes(['application/pdf'])
                                ->required()
                                ->directory("pas_foto"),
                        ]),
                    ]),

                Section::make('Review')
                    ->description('Validasi data pemain')
                    ->icon(Heroicon::CheckBadge)
                    ->schema([
                        Select::make('status')
                            ->label('Status Form')
                            ->options([
                                0 => 'Belum diverifikasi',
                                1 => 'Kurang',
                                2 => 'Tidak Lengkap',
                                3 => 'Sah',
                            ])
                            ->native(false)
                            ->disabled(true),

                        Textarea::make('keterangan')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull()
                            ->disabled(true),

                    ])
                    ->columns(2)
                    ->compact(),

                Actions::make([
                    Action::make('kembali')
                        ->label('Kembali')
                        ->icon(Heroicon::ArrowLeft)
                        ->color('gray')
                        ->outlined()
                        ->action('kembali'),

                    Action::make('update')
                        ->label('Update')
                        ->icon(Heroicon::PencilSquare)
                        ->color('primary')
                        ->action('updateFormPemain'),

                    Action::make('delete')
                        ->label('Hapus Permintaan')
                        ->icon(Heroicon::Trash)
                        ->color('danger')
                        ->modal() // 👈 REQUIRED inside form actions
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Permintaan')
                        ->modalDescription('Apakah Anda yakin ingin menghapus permintaan pemain ini? Tindakan ini tidak dapat dibatalkan.')
                        ->modalSubmitActionLabel('Ya, Hapus')
                        ->modalCancelActionLabel('Batal')
                        ->action('deleteFormPemain'),

                ])->columnSpanFull(),

            ])->statePath('data');
    }



    public function getTitle(): string
    {
        return ($this->formPemain?->nama_lengkap ?? '');
    }

    public function kembali()
    {
        return redirect()->to(\App\Filament\Pages\DaftarPemain::getUrl());
    }

    public function updateFormPemain()
    {
        $data = $this->form->getState();

        try {
            $this->formPemain->update(array_merge($data, [
                'added_by' => auth()->id(),
            ]));

            Notification::make()
                ->title('Berhasil')
                ->body('Data pemain berhasil diperbarui')
                ->success()
                ->send();

            return redirect()->to(\App\Filament\Pages\DaftarPemain::getUrl());
        } catch (\Throwable $th) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body($th->getMessage())
                ->danger()
                ->send();

            throw $th;
        }
    }

    public function deleteFormPemain()
    {
        try {
            $this->formPemain->delete();

            Notification::make()
                ->title('Berhasil')
                ->body('Data pemain berhasil dihapus')
                ->success()
                ->send();

            return redirect()->to(\App\Filament\Pages\DaftarPemain::getUrl());
        } catch (\Throwable $th) {
            Notification::make()
                ->title('Gagal menghapus data')
                ->body($th->getMessage())
                ->danger()
                ->send();

            throw $th;
        }
    }
}
