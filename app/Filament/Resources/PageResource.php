<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationLabel = 'Страницы';

    protected static ?string $modelLabel = 'страница';

    protected static ?string $pluralModelLabel = 'Страницы';

    protected static ?string $navigationGroup = 'Контент';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')->label('Заголовок')->required(),
            Forms\Components\TextInput::make('slug')->label('URL (slug)')->required()
                ->helperText('Будет доступна по адресу /p/{slug}'),
            Forms\Components\Textarea::make('body')->label('Содержимое (HTML)')->rows(15)->columnSpanFull(),
            Forms\Components\Toggle::make('is_active')->label('Опубликована')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Заголовок')->searchable(),
                Tables\Columns\TextColumn::make('slug')->label('URL'),
                Tables\Columns\IconColumn::make('is_active')->label('Опубликована')->boolean(),
                Tables\Columns\TextColumn::make('updated_at')->label('Обновлена')->dateTime('d.m.Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Редактировать'),
                Tables\Actions\DeleteAction::make()->label('Удалить'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
