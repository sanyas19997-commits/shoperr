<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Категории';

    protected static ?string $modelLabel = 'категория';

    protected static ?string $pluralModelLabel = 'Категории';

    protected static ?string $navigationGroup = 'Каталог';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('slug')
                ->label('URL (slug)')
                ->helperText('Если оставить пустым, будет создан автоматически')
                ->maxLength(255),
            Forms\Components\Textarea::make('description')
                ->label('Описание')
                ->rows(4)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('image')
                ->label('Изображение')
                ->image()
                ->directory('categories')
                ->maxSize(4096),
            Forms\Components\Select::make('parent_id')
                ->label('Родительская категория')
                ->relationship('parent', 'name')
                ->searchable()
                ->preload(),
            Forms\Components\TextInput::make('sort_order')
                ->label('Порядок сортировки')
                ->required()
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_active')
                ->label('Активна')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')->label(''),
                Tables\Columns\TextColumn::make('name')->label('Название')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('parent.name')->label('Родитель'),
                Tables\Columns\TextColumn::make('products_count')
                    ->label('Товаров')
                    ->counts('products'),
                Tables\Columns\TextColumn::make('sort_order')->label('Порядок')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Активна')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Только активные'),
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
