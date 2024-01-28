<?php

namespace App\Filament\Resources\Admin;

use App\Filament\Resources\Admin\ProductResource\Pages;
use App\Filament\Resources\Admin\ProductResource\RelationManagers;
use App\Models\Admin\Product;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 1;

    public static function getNavigationGroup() : string {
        return __("Catalogs");
    }

    public static function getNavigationLabel() : string{
        return __("Product");
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                            SpatieMediaLibraryFileUpload::make('product_image')
                                ->multiple()
                                ->reorderable()
                                ->responsiveImages()
                                ->optimize('webp')
                                ->columnSpan('full'),
                    ]),
                Grid::make()
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) {
                                if (($get('slug') ?? '') !== Str::slug($old)) {
                                    return;
                                }

                                $set('slug', Str::slug($state));
                            })
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Grid::make()
                    ->schema([
                        Select::make('currency_id')
                            ->label(__("Currency"))
                            ->relationship("currency", "currency")
                            ->required(),

                        TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('$'),
                        TextInput::make('purchase_price')
                            ->required()
                            ->numeric(),
                    ])->columns(3),

                Forms\Components\Textarea::make('description')
                    ->required()
                    ->maxLength(255),

                Grid::make()
                    ->schema([
                        TextInput::make('stock_quantity')
                            ->required()
                            ->numeric()
                            ->default(0),
                        TextInput::make('product_type')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),

                Grid::make()
                    ->schema([
                        Forms\Components\Toggle::make('is_downloadable')
                            ->required(),
                        Forms\Components\Toggle::make('available_market')
                            ->required(),
                        Forms\Components\Toggle::make('status')
                            ->required(),
                        Forms\Components\Toggle::make('is_downloaddable')
                            ->required(),
                    ])->columns(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('currency_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shop_id')
                    ->numeric()
                    ->sortable(),

                SpatieMediaLibraryImageColumn::make('product_image')
                    ->circular()
                    ->stacked()
                    ->limit(4)
                    ->conversion('thumb'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('purchase_price')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('product_type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_downloadable')
                    ->boolean(),
                Tables\Columns\IconColumn::make('available_market')
                    ->boolean(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_downloaddable')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'view' => Pages\ViewProduct::route('/{record}'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
