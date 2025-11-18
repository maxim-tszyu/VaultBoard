<?php

namespace App\Enums;


use App\Traits\EnumTrait;

enum SpendingCategory: string
{
    use EnumTrait;

    case FOOD = 'Продукты';
    case RESTAURANTS = 'Кафе/Рестораны';
    case TRANSPORT = 'Транспорт';
    case HOUSING = 'Жильё';
    case UTILITIES = 'Коммунальные услуги';
    case INTERNET = 'Интернет/Связь';
    case HEALTH = 'Здоровье';
    case FITNESS = 'Спорт/Фитнес';
    case ENTERTAINMENT = 'Развлечения';
    case SHOPPING = 'Покупки';
    case EDUCATION = 'Образование';
    case TRAVEL = 'Путешествия/Отдых';
    case GIFTS = 'Подарки/Благотворительность';
    case OTHER = 'Прочее';
}