<?php

declare(strict_types=1);

namespace App\MoonShine\Resources\MongoUser;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use MoonShine\UI\Fields\ID;
use MoonShine\UI\Fields\Text;
use MoonShine\UI\Fields\Email;
use MoonShine\UI\Fields\Password;
use MoonShine\Decorations\Block;
use Illuminate\Validation\Rule;
use MoonShine\Laravel\Resources\ModelResource;
use MoonShine\Contracts\Core\PageContract;
use App\MoonShine\Resources\MongoUser\Pages\MongoUserIndexPage;
use App\MoonShine\Resources\MongoUser\Pages\MongoUserFormPage;

/**
 * @extends ModelResource<User>
 */
class MongoUserResource extends ModelResource
{
    protected string $model = User::class;

    protected string $title = 'Usuarios';

    // Columna que se muestra como identificador en listados
    public string $column = 'name';

    public function fields(): array
    {
        return [
            Block::make([
                // El ID en Mongo es un ObjectId, MoonShine lo maneja como string
                ID::make()->sortable(),

                Text::make('Nombre', 'name')
                    ->required()
                    ->sortable(),

                Email::make('Correo', 'email')
                    ->required()
                    ->showOnExport(),

                // Campo de Contraseña
                Password::make('Contraseña', 'password')
                    ->hideOnIndex()
                    ->hideOnDetail()
                    ->creationRules(['required', 'string', 'min:8', 'confirmed'])
                    ->updateRules(['nullable', 'string', 'min:8', 'confirmed']),

                // Campo de confirmación (necesario por la regla 'confirmed')
                Password::make('Confirmar contraseña', 'password_confirmation')
                    ->hideOnIndex()
                    ->hideOnDetail()
                    ->hideOnUpdate()
                    ->creationRules(['required'])
                    ->updateRules(['nullable']),
            ]),
        ];
    }

    // Reglas de validación base (funciona con Mongo: usamos getKey() y getKeyName())
    public function rules(mixed $item): array
    {
        return [
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($item?->getKey(), $item?->getKeyName() ?? '_id'),
            ],
        ];
    }

    public function search(): array
    {
        return ['_id', 'name', 'email'];
    }

    // Si no tienes pages específicas, puedes eliminar/omitir este método y usar las páginas por defecto de MoonShine.
    protected function pages(): array
    {
        return [
            MongoUserIndexPage::class,
            MongoUserFormPage::class,
        ];
    }
}
