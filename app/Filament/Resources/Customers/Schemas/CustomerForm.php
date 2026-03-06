<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Nama Tim')
                ->required(),

            FileUpload::make('logo')
                ->label('Logo Tim')
                ->image() 
                ->disk('public') // TAMBAHKAN INI: Agar Filament tahu harus mencari di folder 'public'
                ->directory('team-logos')
                ->imageEditor()
                ->required() 
                ->validationMessages([
                    'required' => 'Wajib mengunggah logo tim untuk melanjutkan.',
                ]),
        ]);
    }
}