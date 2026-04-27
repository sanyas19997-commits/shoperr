<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Настройки сайта';

    protected static ?string $title = 'Настройки сайта';

    protected static ?string $navigationGroup = 'Контент';

    protected static string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $defaults = [
            'site_name' => Setting::get('site_name', 'Billaro Store'),
            'phone' => Setting::get('phone', '+7 (495) 000-00-00'),
            'email' => Setting::get('email', 'info@billaro.ru'),
            'address' => Setting::get('address', 'г. Москва'),
            'working_hours' => Setting::get('working_hours', 'Пн-Пт 9:00-20:00'),
            'hero_title' => Setting::get('hero_title', 'Качественные товары для всей семьи'),
            'hero_subtitle' => Setting::get('hero_subtitle', 'Большой выбор, выгодные цены и быстрая доставка по всей России.'),
            'about_text' => Setting::get('about_text', ''),
        ];

        $this->form->fill($defaults);
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Общее')->schema([
                TextInput::make('site_name')->label('Название магазина')->required(),
                TextInput::make('phone')->label('Телефон')->required(),
                TextInput::make('email')->label('Email')->email()->required(),
                TextInput::make('address')->label('Адрес'),
                TextInput::make('working_hours')->label('Часы работы'),
            ])->columns(2),
            Section::make('Главная страница')->schema([
                TextInput::make('hero_title')->label('Заголовок баннера'),
                Textarea::make('hero_subtitle')->label('Подзаголовок баннера')->rows(2),
            ]),
            Section::make('О магазине')->schema([
                Textarea::make('about_text')->label('Текст «О магазине»')->rows(8),
            ]),
        ])->statePath('data');
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('save')->label('Сохранить')->action('save')->color('primary'),
        ];
    }

    public function save(): void
    {
        foreach ($this->form->getState() as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()->title('Настройки сохранены')->success()->send();
    }
}
