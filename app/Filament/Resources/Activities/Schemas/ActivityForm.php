<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ActivityForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // BASIC
            TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255),

            Textarea::make('short_description')
                ->label('Short Description')
                ->required()
                ->maxLength(255)
                ->rows(3),

            DatePicker::make('date')
                ->label('Date')
                ->required()
                ->native(false),

            TextInput::make('location')
                ->label('Location')
                ->maxLength(255)
                ->nullable(),

            // COVER IMAGE (disimpan seperti Alumni)
            // NOTE: kalau kolom kamu namanya `image`, ganti make('image_path') -> make('image')
            FileUpload::make('image_path')
                ->label('Cover Image')
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatioOptions([
                    '16:9',
                    '4:3',
                    '1:1',
                ])
                ->disk('public')
                ->directory('activities')
                ->visibility('public')
                ->imagePreviewHeight('200')
                ->maxSize(2048)
                ->acceptedFileTypes([
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ])
                // optional: biar cover rapi
                ->imageCropAspectRatio('16:9')
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(1280)
                ->imageResizeTargetHeight(720),

            // DESCRIPTION (Rich Text, no image)
            RichEditor::make('description')
                ->label('Description')
                ->required()
                ->columnSpanFull()
                // hilangkan tombol attachFiles (yang biasa dipakai upload/insert file/image)
                ->toolbarButtons([
                    ['bold', 'italic', 'underline', 'strike', 'link'],
                    ['h2', 'h3', 'bulletList', 'orderedList'],
                    ['blockquote', 'codeBlock'],
                    ['undo', 'redo'],
                ])
                // hard-block attachment di backend (drag-drop/paste file juga ketolak)
                ->fileAttachmentsAcceptedFileTypes([]),

            // SYSTEM (display-only)
            TextInput::make('created_by')
                ->label('Created By')
                ->disabled()
                ->dehydrated(false)
                ->default(fn () => auth()->user()?->name),

            TextInput::make('updated_by')
                ->label('Updated By')
                ->disabled()
                ->dehydrated(false)
                ->default(fn () => auth()->user()?->name),
        ]);
    }
}
