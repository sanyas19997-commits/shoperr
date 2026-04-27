<?php

return [
    'required' => 'Поле «:attribute» обязательно для заполнения.',
    'email' => 'Поле «:attribute» должно быть корректным email-адресом.',
    'max' => [
        'string' => 'Поле «:attribute» не может быть длиннее :max символов.',
        'numeric' => 'Поле «:attribute» не может быть больше :max.',
    ],
    'min' => [
        'string' => 'Поле «:attribute» должно быть не короче :min символов.',
        'numeric' => 'Поле «:attribute» должно быть не меньше :min.',
    ],
    'unique' => 'Такое значение «:attribute» уже занято.',
    'confirmed' => 'Поле «:attribute» не совпадает с подтверждением.',
    'numeric' => 'Поле «:attribute» должно быть числом.',
    'integer' => 'Поле «:attribute» должно быть целым числом.',
    'string' => 'Поле «:attribute» должно быть строкой.',
    'in' => 'Выбранное значение для «:attribute» некорректно.',

    'attributes' => [
        'name' => 'имя',
        'email' => 'email',
        'phone' => 'телефон',
        'password' => 'пароль',
        'message' => 'сообщение',
        'customer_name' => 'ФИО',
        'customer_email' => 'email',
        'customer_phone' => 'телефон',
        'address' => 'адрес',
        'city' => 'город',
    ],
];
