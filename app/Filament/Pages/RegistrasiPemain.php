<?php

namespace App\Filament\Pages;

use App\Models\Pemain;
use App\Models\PemainFormRegistration;
use App\Models\User;
use BackedEnum;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions\Action;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Components\Wizard\Step;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Grid;
use Illuminate\Support\Facades\Http;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class RegistrasiPemain extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.registrasi-pemain';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Users;
    protected static string|UnitEnum|null $navigationGroup = "Pemain";
    protected static ?string $navigationLabel = 'Single Registration Pemain';

    public ?array $data = [];
    public array $countries = [];
    public array $provinces = [];
    public $isIndonesia = false;


    public function mount(): void
    {
        $this->form->fill();
        $this->loadCountries();
        $this->loadProvinces();
    }

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
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
            // Handle error
        }
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Step::make('Data Pribadi')
                        ->schema([
                            TextInput::make('nama_lengkap')
                                ->label("Nama Lengkap")
                                ->required(),

                            TextInput::make('panggilan')
                                ->label("Panggilan")
                                ->required(),

                            DatePicker::make('tanggal_lahir')
                                ->label("Tanggal Lahir")
                                ->required()
                                ->native(false)
                                ->suffixIcon(Heroicon::Calendar),

                            TextInput::make('no_id')
                                ->label("No ID")
                                ->required(),

                            Select::make('jenis_id')
                                ->label("Jenis ID")
                                ->options([
                                    'nik' => 'NIK',
                                    'pasport' => 'Pasport',
                                    'kia' => 'KIA',
                                ])
                                ->native(false)
                                ->required(),

                            Select::make('kewarganegaraan')
                                ->label('Kewarganegaraan')
                                ->options(fn() => $this->countries)
                                ->searchable()
                                ->native(false)
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('provinsi', null);
                                    $set('kota', null);
                                })
                                ->required(),

                            Select::make('provinsi')
                                ->label('Provinsi')
                                ->options(fn() => $this->provinces)
                                ->searchable()
                                ->native(false)
                                ->live()
                                ->afterStateUpdated(function (Set $set) {
                                    $set('kota', null);
                                })
                                ->disabled(fn(Get $get) => $get('kewarganegaraan') !== 'Indonesia')
                                ->required(fn(Get $get) => $get('kewarganegaraan') === 'Indonesia'),

                            Select::make('kota')
                                ->label('Kota')
                                ->options(function (Get $get, Set $set) {
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
                                    } catch (\Exception $e) {
                                        return [];
                                    }
                                })
                                ->searchable()
                                ->native(false)
                                ->disabled(fn(Get $get) => $get('kewarganegaraan') !== 'Indonesia' || !$get('provinsi'))
                                ->required(fn(Get $get) => $get('kewarganegaraan') === 'Indonesia'),

                            Grid::make(1)
                                ->schema([
                                    Grid::make(2)
                                        ->schema([
                                            TextInput::make('tinggi_badan')
                                                ->label('Tinggi Badan')
                                                ->suffix("cm")
                                                ->numeric()
                                                ->required(),

                                            TextInput::make('berat_badan')
                                                ->label('Berat Badan')
                                                ->suffix("kg")
                                                ->numeric(),
                                        ]),

                                    TextInput::make('no_hp')
                                        ->label("No HP")
                                        ->helperText("Diawali dengan kode negara, untuk Indonesia 62")
                                        ->prefix("+")
                                        ->tel()
                                        ->required(),
                                ])
                                ->columnSpan(1),

                            Textarea::make('alamat')
                                ->label('Alamat')
                                ->rows(4)
                                ->maxLength(500)
                                ->required()
                                ->columnSpan(1),

                            TextInput::make('email')
                                ->label("Email")
                        ])
                        ->columns(2),
                    Step::make('Upload File')->schema([

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

                        FileUpload::make('surat_kerjasama_file_path')
                            ->label("Surat Kerjasama")
                            ->acceptedFileTypes(['application/pdf'])
                            ->required()
                            ->directory("pas_foto"),

                        FileUpload::make('identitas_file_path')
                            ->label("Foto Kartu Identitas KTP/KIA")
                            ->image()
                            ->minSize(10)
                            ->maxSize(20000)
                            ->required()
                            ->directory("identitas"),



                    ])->columns(2)
                ])
                    ->nextAction(fn(Action $action) => $action->label('Selanjutnya'))
                    ->previousAction(fn(Action $action) => $action->label('Sebelumnya'))
                    ->submitAction(
                        Action::make('submit')
                            ->label('Simpan')
                            ->icon('heroicon-o-check')
                            ->action('create')
                    )

            ])
            ->statePath('data');
    }

    public function create(): void
    {
        try {
            $data = $this->form->getState();

            if ($data['kewarganegaraan'] === 'Indonesia') {
                $data['provinsi'] = $this->provinces[$data['provinsi']];
            }

            $user = User::with('adminClubs')->find(auth()->id());

            $admin_data = $user->toArray();

            PemainFormRegistration::create(array_merge($data, [
                'added_by' => $admin_data["id"],
                'club_id' => $admin_data["admin_clubs"][0]["club_id"]
            ]));


            Notification::make()
                ->title('Data berhasil disimpan')
                ->success()
                ->send();

            redirect("/pssi_admin/registrasi-pemain");
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body($e->getMessage())
                ->danger()
                ->send();

            throw $e;
        }
    }
}
