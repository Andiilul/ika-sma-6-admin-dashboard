<?php

namespace App\Filament\Resources\News\Schemas;

use App\Enums\NewsStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            // BASIC
            TextInput::make('title')
                ->label('Title')
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    // Auto-generate slug ONLY if slug still empty
                    if (blank($get('slug')) && filled($state)) {
                        $set('slug', Str::slug($state));
                    }
                }),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->maxLength(255)
                ->unique(ignoreRecord: true)
                // normalize slug on save
                ->dehydrateStateUsing(fn ($state) => Str::slug($state))
                ->helperText('Unique URL identifier. Auto-generated from title if empty.'),

            Textarea::make('excerpt')
                ->label('Excerpt / Short Description')
                ->nullable()
                ->maxLength(500)
                ->rows(3),

            // CONTENT (Rich Text)
            RichEditor::make('content')
                ->label('Content')
                ->required()
                ->columnSpanFull()
                ->toolbarButtons([
                    ['bold', 'italic', 'underline', 'strike', 'link'],
                    ['h2', 'h3', 'bulletList', 'orderedList'],
                    ['blockquote', 'codeBlock'],
                    ['undo', 'redo'],
                ])
                // block attachments (paste/drag file/image)
                ->fileAttachmentsAcceptedFileTypes([]),

            // PUBLISHING
            Select::make('status')
                ->label('Status')
                ->required()
                ->options([
                    NewsStatus::Draft->value => 'Draft',
                    NewsStatus::Published->value => 'Published',
                    NewsStatus::Scheduled->value => 'Scheduled',
                    NewsStatus::Archived->value => 'Archived',
                ])
                ->default(NewsStatus::Draft->value)
                ->live(),

            DateTimePicker::make('published_at')
                ->label('Published At')
                ->seconds(false)
                ->nullable()
                ->native(false)
                ->visible(fn (callable $get) => in_array($get('status'), [
                    NewsStatus::Published->value,
                    NewsStatus::Scheduled->value,
                ], true))
                ->helperText('Set future time for Scheduled. If Published and empty, it will be auto-set.'),

            // AUTHOR (FK)
            Select::make('author_id')
                ->label('Author')
                ->relationship('author', 'name')
                ->searchable()
                ->preload()
                ->default(fn () => auth()->id())
                ->required(),

            // SEO
            TextInput::make('meta_title')
                ->label('Meta Title')
                ->nullable()
                ->maxLength(255),

            Textarea::make('meta_description')
                ->label('Meta Description')
                ->nullable()
                ->maxLength(500)
                ->rows(3),

            // OG IMAGE
            FileUpload::make('og_image_path')
                ->label('OG Image')
                ->image()
                ->imageEditor()
                ->imageEditorAspectRatioOptions([
                    '1:1',
                    '16:9',
                    '4:3',
                ])
                ->disk('public')
                ->directory('news/og')
                ->visibility('public')
                ->imagePreviewHeight('200')
                ->maxSize(2048)
                ->acceptedFileTypes([
                    'image/jpeg',
                    'image/png',
                    'image/webp',
                ])
                ->nullable()
                // optional crop/resize biar rapih untuk preview share
                ->imageCropAspectRatio('1:1')
                ->imageResizeMode('cover')
                ->imageResizeTargetWidth(1200)
                ->imageResizeTargetHeight(1200),

            // SYSTEM (display-only)
            TextInput::make('created_by')
                ->label('Created By')
                ->disabled()
                ->dehydrated(false)
                ->default(fn ($record) => $record?->author?->name ?? auth()->user()?->name),

            TextInput::make('updated_by')
                ->label('Updated By')
                ->disabled()
                ->dehydrated(false)
                ->default(fn () => auth()->user()?->name),
        ]);
    }
}