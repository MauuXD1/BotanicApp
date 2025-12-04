<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MongoUser\Pages;

use MoonShine\Laravel\Pages\Crud\FormPage;
use MoonShine\Contracts\Core\ResourceContract;
use MoonShine\Contracts\UI\FieldContract;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Password;
use App\MoonShine\Resources\MongoUser\MongoUserResource;

/**
 * @extends FormPage<\App\MoonShine\Resources\MongoUser\MongoUserResource>
 */
class MongoUserFormPage extends FormPage
{
    // cambiado: usar el mismo tipo que el padre y asignar una instancia en el constructor
    protected ?ResourceContract $resource = null;

    public function __construct()
    {
        parent::__construct();

        // asigna una instancia del recurso (cumple ResourceContract)
        $this->resource = app(MongoUserResource::class);
    }

    /**
     * @return list<FieldContract>
     */
    protected function fields(): iterable
    {
        return [
            Text::make('Nombre', 'name')->required(),
            Email::make('Correo', 'email')->required(),
            Password::make('Contraseña', 'password')
                ->hideOnIndex()
                ->hideOnDetail(),
            Password::make('Confirmar contraseña', 'password_confirmation')
                ->hideOnIndex()
                ->hideOnDetail()
                ->hideOnUpdate(),
        ];
    }
}
