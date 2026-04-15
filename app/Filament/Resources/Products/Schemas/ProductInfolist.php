<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Product Details')
                    ->tabs([

                        // 🔹 TAB 1
                        Tab::make('Info')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                TextEntry::make('name')
                                    ->label('Product Name')
                                    ->weight('bold')
                                    ->color('primary'),

                                TextEntry::make('id')
                                    ->label('Product ID'),

                                TextEntry::make('sku')
                                    ->label('Product SKU')
                                    ->badge()
                                    ->color('warning'),

                                TextEntry::make('description')
                                    ->label('Product Description'),

                                TextEntry::make('created_at')
                                    ->label('Product Creation Date')
                                    ->dateTime('d F Y')
                                    ->color('info'),
                            ]),

                        // 🔹 TAB 2
                        Tab::make('Price & Stock')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([

                                // ✅ Format harga Rp
                                TextEntry::make('price')
                                    ->label('Product Price')
                                    ->icon('heroicon-o-currency-dollar')
                                    ->formatStateUsing(fn ($state) => 'Rp ' . number_format($state, 0, ',', '.')),

                                // ✅ Badge dinamis stock
                                TextEntry::make('stock')
                                    ->label('Product Stock')
                                    ->badge()
                                    ->icon(fn ($state) =>
                                        $state == 0 ? 'heroicon-o-x-circle' :
                                        ($state <= 10 ? 'heroicon-o-exclamation-circle' : 'heroicon-o-check-circle')
                                    )
                                    ->color(fn ($state) =>
                                        $state == 0 ? 'danger' :
                                        ($state <= 10 ? 'warning' : 'success')
                                    )
                                    ->formatStateUsing(fn ($state) =>
                                        $state == 0 ? 'Out of Stock' :
                                        ($state <= 10 ? 'Low Stock (' . $state . ')' : 'In Stock (' . $state . ')')
                                    ),
                            ]),

                        // 🔹 TAB 3
                        Tab::make('Image and Status')
                            ->icon('heroicon-o-photo')
                            ->schema([
                                ImageEntry::make('image')
                                    ->label('Product Image')
                                    ->disk('public'),

                                IconEntry::make('is_active')
                                    ->label('Status')
                                    ->boolean(),

                                IconEntry::make('is_featured')
                                    ->label('Featured')
                                    ->boolean(),
                            ]),
                    ])
                    ->columnSpanFull()
            ]);
    }
}