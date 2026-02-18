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

class PemainDetail extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.pemain-detail';

    protected static bool $shouldRegisterNavigation = false;
    public ?PemainFormRegistration $formPemain = null;
    public ?array $data = [];
    public string $pengirim = 'John Doe';
    public string $club = 'Persija Jakarta';

    public function mount(): void
    {
        $selected_id = (int) request()->query('record');
        $this->formPemain = PemainFormRegistration::with(['addedBy', 'club'])
            ->where("id", $selected_id)
            ->firstOrFail();
        $data_lain = $this->formPemain->toArray();
        // dd();
        $this->form->fill(array_merge($data_lain, [
            'pengirim' => $data_lain["added_by"]["name"],
            'club' => $data_lain["club"]["name"]
        ]));
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengiriman')
                    ->description('Data pengirim dan klub')
                    ->icon(Heroicon::BuildingOffice)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('pengirim')
                                ->label('Pengirim')
                                ->disabled()
                                ->default($this->pengirim),

                            TextInput::make('club')
                                ->label('Club')
                                ->disabled()
                                ->default($this->club),
                        ]),
                    ])
                    ->collapsible()
                    ->collapsed(false),

                Section::make('Data Pribadi')
                    ->description('Informasi identitas pemain')
                    ->icon(Heroicon::User)
                    ->schema([
                        Grid::make(2)->schema([
                            TextInput::make('nama_lengkap')->label('Nama Lengkap')->disabled(),
                            TextInput::make('panggilan')->label('Panggilan')->disabled(),

                            DatePicker::make('tanggal_lahir')
                                ->label('Tanggal Lahir')
                                ->native(false)
                                ->suffixIcon(Heroicon::Calendar)
                                ->disabled(),

                            TextInput::make('no_id')->label('No Identitas')->disabled(),

                            Select::make('jenis_id')
                                ->label('Jenis Identitas')
                                ->options([
                                    'nik' => 'NIK',
                                    'pasport' => 'Pasport',
                                    'kia' => 'KIA',
                                ])
                                ->native(false)
                                ->disabled(),

                            TextInput::make('kewarganegaraan')->disabled(),
                            TextInput::make('provinsi')->disabled(),
                            TextInput::make('kota')->disabled(),

                            TextInput::make('tinggi_badan')
                                ->label('Tinggi Badan')
                                ->suffix('cm')
                                ->numeric()
                                ->disabled(),

                            TextInput::make('berat_badan')
                                ->label('Berat Badan')
                                ->suffix('kg')
                                ->numeric()
                                ->disabled(),

                            TextInput::make('no_hp')->label('No HP')->prefix('+')->disabled(),
                            TextInput::make('email')->label('Email')->disabled(),
                        ]),

                        Textarea::make('alamat')
                            ->label('Alamat Lengkap')
                            ->rows(3)
                            ->disabled()
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
                                ->downloadable()
                                ->disabled()
                                ->directory("ijazah"),

                            FileUpload::make('akta_file_path')
                                ->label("File Akta Kelahiran")
                                ->acceptedFileTypes(['application/pdf'])
                                ->downloadable()
                                ->disabled()
                                ->directory("akta"),

                            FileUpload::make('kartu_kelahiran_file_path')
                                ->label("File Kartu Kelahiran")
                                ->acceptedFileTypes(['application/pdf'])
                                ->downloadable()
                                ->disabled()
                                ->directory("kartu_kelahiran"),

                            FileUpload::make('identitas_file_path')
                                ->label("Foto Kartu Identitas KTP/KIA")
                                ->image()
                                ->minSize(10)
                                ->maxSize(20000)
                                ->downloadable()
                                ->disabled()
                                ->directory("identitas"),

                            FileUpload::make('surat_kerjasama_file_path')
                                ->label("Surat Kerjasama")
                                ->acceptedFileTypes(['application/pdf'])
                                ->downloadable()
                                ->disabled()
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
                            ->required(),

                        Textarea::make('keterangan')
                            ->label('Catatan')
                            ->rows(3)
                            ->columnSpanFull(),

                        Grid::make(2)->schema([
                            Action::make('save')
                                ->label('Update Status')
                                ->icon('heroicon-m-check-circle')
                                ->color('success')
                                ->action('saveReview'),

                            Action::make('sahkan')
                                ->label('Sahkan Pemain')
                                ->icon('heroicon-m-shield-check')
                                ->color('primary')
                                ->requiresConfirmation()
                                ->modalIcon('heroicon-o-shield-check')
                                ->modalIconColor('primary')
                                ->modalHeading('Sahkan Status Pemain')
                                ->modalDescription('Apakah Anda yakin ingin mensahkan pemain ini ke dalam klub? Data yang sah akan dikunci untuk registrasi.')
                                ->modalSubmitActionLabel('Ya, Sahkan')
                                ->modalCancelActionLabel('Batal')
                                ->action(function () {
                                    $this->verifiedPemain();
                                })
                                ->disabled(function (Get $get) {
                                    $status = $get("status");
                                    return $status !== 3;
                                }),
                        ]),
                    ])
                    ->columns(2)
                    ->compact(),
            ])->statePath('data');
    }



    public function getTitle(): string
    {
        return ($this->formPemain?->nama_lengkap ?? '');
    }

    public function saveReview()
    {
        try {
            $data = $this->form->getState();

            $this->formPemain->update([
                "status" => $data["status"],
                "keterangan" => $data["keterangan"]
            ]);

            // 1. Send notification to the session so it survives the reload
            Notification::make()
                ->title('Status Data Pemain Berhasil Disimpan')
                ->icon('heroicon-o-check-badge')
                ->iconColor('success')
                ->success()
                ->send();

            // 2. Redirect to the same page with the current query parameters
            return redirect()->to(request()->header('Referer'));
        } catch (\Throwable $e) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body($e->getMessage())
                ->danger()
                ->send();
            throw $e;
        }
    }

    public function verifiedPemain()
    {
        try {
            $pemain_data = $this->formPemain->toArray();
            // dd($pemain_data);

            $cleanName = Str::of($this->formPemain->nama_lengkap)->slug('')->limit(9)->lower();
            $generatedEmail = $cleanName . '@gmail.com';
            $randomPassword = Str::random(8); 

            $user = User::where('email', $generatedEmail)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $this->formPemain->nama_lengkap,
                    'email' => $generatedEmail,
                    'password' => Hash::make($randomPassword),
                    'roles_id' => 2,
                ]);
            }

            $this->formPemain->update([
                "verified_at" => Carbon::now(),
                "verified_by" => auth()->id(),
                "status" => 3
            ]);

            // 4. Create Official Record
            OfficialPemain::updateOrCreate(
                ['user_id' => $user->id],
                $pemain_data
            );

            Notification::make()
                ->title('Pemain Berhasil Disahkan')
                ->icon('heroicon-o-check-badge')
                ->iconColor('success')
                ->success()
                ->send();

            return redirect()->to(\App\Filament\Pages\VerifikasiPemain::getUrl());
        } catch (\Throwable $th) {
            Notification::make()
                ->title('Gagal menyimpan data')
                ->body($th->getMessage())
                ->danger()
                ->send();
            throw $th;
        }
    }
}
