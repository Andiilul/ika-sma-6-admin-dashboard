<?php

namespace App\Filament\Resources\Alumnis\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AlumniForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            // BASIC IDENTITY
            TextInput::make('name')
                ->label('Full Name')
                ->required()
                ->maxLength(255),

            TextInput::make('nisn')
                ->label('NISN')
                ->numeric()
                ->required()
                ->unique(ignoreRecord: true),

            Select::make('gender')
                ->options([
                    'male' => 'Male',
                    'female' => 'Female',
                ])
                ->required(),

            TextInput::make('graduation_year')
                ->label('Graduation Year')
                ->numeric()
                ->required()
                ->minValue(1950)
                ->maxValue(now()->year),

            // PERSONAL DETAILS
            TextInput::make('ethnicity')
                ->maxLength(100)
                ->nullable(),

            TextInput::make('domicile')
                ->label('Domicile')
                ->maxLength(255)
                ->nullable(),

            Textarea::make('address')
                ->rows(3)
                ->nullable(),

            // CAREER
            TextInput::make('profession')
                ->maxLength(255)
                ->nullable(),

            TextInput::make('position')
                ->maxLength(255)
                ->nullable(),


            Select::make('location')
                ->label('Location')
                ->options([
                    'makassar' => 'Makassar',
                    'non-makassar' => 'Outside Makassar', // label UI bebas
                ])
                ->required()
                ->native(false)
                ->rules([
                    'required',
                    'in:makassar,non-makassar',
                ]),


            // PERSONAL
            TextInput::make('hobby')
                ->maxLength(255)
                ->nullable(),

            TextInput::make('contact_number')
                ->label('Contact Number')
                ->tel()
                ->maxLength(20)
                ->nullable(),

            // IMAGE
            FileUpload::make('image_path')
                ->label('Photo')
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatioOptions([
                    '16:9',
                    '4:3',
                    '1:1',
                ])
                ->disk('public')
                ->directory('alumni')
                ->visibility('public')
                ->imagePreviewHeight('200')
                ->maxSize(2048)
                ->acceptedFileTypes([
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ])
                ->imageCropAspectRatio('1:1')
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(600)
                ->imageResizeTargetHeight(600),

            // SYSTEM
            TextInput::make('updated_by')
                ->label('Updated By')
                ->disabled()
                ->dehydrated(false)
                ->default(fn() => auth()->user()?->name),
        ]);
    }
}
