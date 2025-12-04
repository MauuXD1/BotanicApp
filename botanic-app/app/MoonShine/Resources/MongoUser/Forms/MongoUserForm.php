<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MongoUser\Forms;

use MoonShine\Laravel\Forms\Form;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\Contracts\Core\TypeCasts\DataWrapperContract;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Password;
use MoonShine\UI\Fields\ID;
use MoonShine\Support\ListOf;

class MongoUserForm extends Form
{
    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Name')->required(),
            Email::make('Email')->required()->unique(),
            Password::make('Password')->required()->minLength(6),
        ];
    }

    protected function rules(DataWrapperContract $item): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:mongo_users,email,' . $item->getKey(),
            'password' => 'required|string|min:6',
        ];
    }

    protected function buttons(): ListOf
    {
        return parent::buttons();
    }
}