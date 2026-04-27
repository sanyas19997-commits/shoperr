<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Товары';

    protected static ?string $modelLabel = 'товар';

    protected static ?string $pluralModelLabel = 'Товары';

    protected static ?string $navigationGroup = 'Каталог';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Основное')->schema([
                Forms\Components\TextInput::make('name')->label('Название')->required()->maxLength(255)->columnSpan(2),
                Forms\Components\TextInput::make('slug')->label('URL (slug)')->maxLength(255)->helperText('Авто, если пусто'),
                Forms\Components\TextInput::make('sku')->label('Артикул (SKU)')->maxLength(64),
                Forms\Components\Select::make('category_id')->label('Категория')
                    ->relationship('category', 'name')->searchable()->preload(),
                Forms\Components\Textarea::make('short_description')->label('Краткое описание')->rows(2)->columnSpanFull(),
                Forms\Components\Textarea::make('description')->label('Полное описание')->rows(8)->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make('Цена и наличие')->schema([
                Forms\Components\TextInput::make('price')->label('Цена, ₽')->required()->numeric()->minValue(0)->step(0.01),
                Forms\Components\TextInput::make('sale_price')->label('Цена со скидкой, ₽')->numeric()->minValue(0)->step(0.01)
                    ->helperText('Оставьте пустым, если скидки нет'),
                Forms\Components\TextInput::make('stock')->label('Остаток на складе')->required()->numeric()->minValue(0)->default(0),
            ])->columns(3),

            Forms\Components\Section::make('Изображения')->schema([
                Forms\Components\FileUpload::make('image')->label('Главное изображение')->image()->directory('products')->maxSize(4096),
                Forms\Components\Repeater::make('images')->label('Дополнительные изображения')
                    ->relationship()
                    ->schema([
                        Forms\Components\FileUpload::make('path')->label('Файл')->image()->directory('products')->required(),
                        Forms\Components\TextInput::make('alt')->label('Подпись (alt)'),
                        Forms\Components\TextInput::make('sort_order')->label('Порядок')->numeric()->default(0),
                    ])
                    ->columns(3)
                    ->collapsible()
                    ->columnSpanFull(),
            ]),

            Forms\Components\Section::make('Видимость')->schema([
                Forms\Components\Toggle::make('is_active')->label('Активен')->default(true),
                Forms\Components\Toggle::make('is_featured')->label('Хит продаж'),
                Forms\Components\TextInput::make('sort_order')->label('Порядок сортировки')->numeric()->default(0),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label('')->square(),
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable()->sortable()->wrap(),
                Tables\Columns\TextColumn::make('sku')->label('Артикул')->searchable(),
                Tables\Columns\TextColumn::make('category.name')->label('Категория')->sortable(),
                Tables\Columns\TextColumn::make('price')->label('Цена')->money('rub')->sortable(),
                Tables\Columns\TextColumn::make('sale_price')->label('Скидка')->money('rub'),
                Tables\Columns\TextColumn::make('stock')->label('Остаток')->numeric()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Активен')->boolean(),
                Tables\Columns\IconColumn::make('is_featured')->label('Хит')->boolean(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')->label('Категория')->relationship('category', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')->label('Активные'),
                Tables\Filters\TernaryFilter::make('is_featured')->label('Хиты продаж'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Редактировать'),
                Tables\Actions\DeleteAction::make()->label('Удалить'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
