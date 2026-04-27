<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Schema;
use App\Models\Category;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 🔥 KIRI (2/3)
                Group::make([
                    Section::make('Post Details')
                        ->description('Fill in the main content')
                        ->icon('heroicon-o-document-text')
                        ->schema([
                            TextInput::make('title')
                                ->rules('required|min:5|max:10')
                                ->validationMessages([
                                    'required' => 'Title wajib diisi',
                                    'min' => 'Title minimal 5 karakter',
                                ]),

                            TextInput::make('slug')
                                ->rules('required|min:3')
                                ->unique(ignoreRecord: true)
                                ->validationMessages([
                                    'unique' => 'Slug harus unik',
                                    'min' => 'Slug minimal 3 karakter',
                                ]),

                            Select::make('category_id')
                                ->relationship('category', 'name')
                                ->options(Category::all()->pluck('name', 'id'))
                                ->required()
                                ->validationMessages([
                                    'required' => 'Category wajib dipilih',
                                ])
                                // ->preload()
                                ->searchable(),

                            ColorPicker::make('color'),

                            RichEditor::make('body')
                                ->columnSpanFull(),
                        ])
                        ->columns(2),
                ])->columnSpan(2),

                // 🔥 KANAN (1/3)
                Group::make([
                    Section::make('Meta')
                        ->icon('heroicon-o-cog')
                        ->schema([
                            Toggle::make('published')
                                ->label('Published'),

                            DateTimePicker::make('published_at'),

                            Select::make('tags')
                                ->relationship('tags', 'name')
                                ->multiple()
                                ->preload()
                                ->searchable(),
                        ]),

                    Section::make('Thumbnail')
                        ->icon('heroicon-o-photo')
                        ->schema([
                            FileUpload::make('image')
                                ->required()
                                ->validationMessages([
                                    'required' => 'Image wajib diupload',
                                ])
                                ->disk('public')
                                ->directory('posts'),
                        ]),
                ])->columnSpan(1),

            ])
            ->columns(3); 
    }
}