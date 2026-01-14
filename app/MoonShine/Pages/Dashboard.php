<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Laravel\Pages\Page;
use MoonShine\Contracts\UI\ComponentContract;
use App\Models\Planta;
use MoonShine\UI\Components\Metrics\Wrapped\ValueMetric;
use MoonShine\UI\Fields\Preview;
#[\MoonShine\MenuManager\Attributes\SkipMenu]


class Dashboard extends Page
{
    /**
     * @return array<string, string>
     */
    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle()
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Dashboard';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
	{
		return [
            ValueMetric::make('Total de Plantas Registradas')
            ->value(Planta::count())->icon('s.archive-box-arrow-down'),

            ValueMetric::make('Meta Mensual de Plantas Registradas de 100')
            ->value(Planta::whereMonth('created_at', now()->month)->count())
            ->progress(100) 
            ->columnSpan(4)->icon('m.chart-pie'),
            Preview::make('Mapa de la zona')
            ->fill(view('admin.components.map-picker', ['uniqueId' => uniqid()])),
        ];
	}
}
