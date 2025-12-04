<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MongoUser;

use MoonShine\Laravel\Resources\Resource;
use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\ID;
use App\Models\MongoUser;

/**
 * @extends Resource<MongoUser>
 */
class MongoUserResource extends Resource
{
    public static string $model = MongoUser::class;

    public function fields(): iterable
    {
        return [
            ID::make(),
            Text::make('Name')->required(),
            Email::make('Email')->required(),
            // Add other fields as necessary
        ];
    }

    public function labels(): array
    {
        return [
            'singular' => 'Mongo User',
            'plural' => 'Mongo Users',
        ];
    }

    public function routes(): array
    {
        return [
            'index' => 'mongo-users.index',
            'create' => 'mongo-users.create',
            'edit' => 'mongo-users.edit',
        ];
    }

    public function title(): string
    {
        return 'Mongo Users';
    }

    public function icon(): string
    {
        return 'users';
    }
}