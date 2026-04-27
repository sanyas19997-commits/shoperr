<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Заказы';

    protected static ?string $modelLabel = 'заказ';

    protected static ?string $pluralModelLabel = 'Заказы';

    protected static ?string $navigationGroup = 'Магазин';

    protected static ?int $navigationSort = 0;

    public static function getNavigationBadge(): ?string
    {
        return (string) Order::where('status', 'new')->count();
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Заказ')->schema([
                Forms\Components\TextInput::make('number')->label('Номер')->disabled(),
                Forms\Components\Select::make('status')->label('Статус')
                    ->options(Order::STATUSES)
                    ->required(),
                Forms\Components\Select::make('payment_status')->label('Статус оплаты')->options([
                    'pending' => 'Ожидает',
                    'paid' => 'Оплачен',
                    'failed' => 'Ошибка',
                    'refunded' => 'Возврат',
                ])->required(),
                Forms\Components\TextInput::make('total')->label('Сумма, ₽')->disabled(),
            ])->columns(4),
            Forms\Components\Section::make('Покупатель')->schema([
                Forms\Components\TextInput::make('customer_name')->label('ФИО')->required(),
                Forms\Components\TextInput::make('customer_email')->label('Email')->email(),
                Forms\Components\TextInput::make('customer_phone')->label('Телефон')->required(),
            ])->columns(3),
            Forms\Components\Section::make('Доставка')->schema([
                Forms\Components\Select::make('delivery_method')->label('Способ доставки')->options(Order::DELIVERY_METHODS),
                Forms\Components\TextInput::make('city')->label('Город'),
                Forms\Components\TextInput::make('address')->label('Адрес')->columnSpanFull(),
            ])->columns(3),
            Forms\Components\Section::make('Оплата')->schema([
                Forms\Components\Select::make('payment_method')->label('Способ оплаты')->options(Order::PAYMENT_METHODS),
            ]),
            Forms\Components\Section::make('Комментарий')->schema([
                Forms\Components\Textarea::make('comment')->label('Комментарий покупателя')->rows(3)->disabled(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')->label('№')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')->label('Дата')->dateTime('d.m.Y H:i')->sortable(),
                Tables\Columns\TextColumn::make('customer_name')->label('Покупатель')->searchable(),
                Tables\Columns\TextColumn::make('customer_phone')->label('Телефон'),
                Tables\Columns\TextColumn::make('total')->label('Сумма')->money('rub')->sortable(),
                Tables\Columns\BadgeColumn::make('status')->label('Статус')
                    ->formatStateUsing(fn ($state) => Order::STATUSES[$state] ?? $state)
                    ->colors([
                        'warning' => 'new',
                        'primary' => ['processing', 'paid'],
                        'info' => 'shipped',
                        'success' => 'delivered',
                        'danger' => 'canceled',
                    ]),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')->label('Статус')->options(Order::STATUSES),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label('Просмотр'),
                Tables\Actions\EditAction::make()->label('Изменить'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            OrderResource\RelationManagers\ItemsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
