<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Товары в заказе';

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->label('Название')->required(),
            Forms\Components\TextInput::make('price')->label('Цена')->numeric()->required(),
            Forms\Components\TextInput::make('quantity')->label('Количество')->numeric()->required(),
            Forms\Components\TextInput::make('subtotal')->label('Сумма')->numeric()->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Название'),
                Tables\Columns\TextColumn::make('sku')->label('Артикул'),
                Tables\Columns\TextColumn::make('price')->label('Цена')->money('rub'),
                Tables\Columns\TextColumn::make('quantity')->label('Кол-во'),
                Tables\Columns\TextColumn::make('subtotal')->label('Сумма')->money('rub'),
            ])
            ->headerActions([])
            ->actions([])
            ->bulkActions([]);
    }
}
