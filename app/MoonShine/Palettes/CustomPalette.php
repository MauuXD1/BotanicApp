<?php

declare(strict_types=1);

namespace App\MoonShine\Palettes;

use MoonShine\Contracts\ColorManager\PaletteContract;

final class CustomPalette implements PaletteContract
{
    public function getDescription(): string
    {
        return 'Your custom palette';
    }

    public function getColors(): array
    {
        return [
            'body' => 'oklch(97% 0.03 140)',
            'primary' => 'oklch(45% 0.18 140)',
            'primary-text' => 'oklch(100% 0 0)',
            'secondary' => 'oklch(45% 0.8 140)',
            'secondary-text' => 'oklch(5% 0 0)',
            'success' => 'oklch(40% 0.6 140)',
            'success-text' => 'oklch(10% 0 0)',
            'warning' => 'oklch(50% 0.15 85)',
            'warning-text' => 'oklch(10% 0.05 140)',
            'error' => 'oklch(50% 0.2 1)',
            'error-text' => 'oklch(100% 0 0)',
            'info' => 'oklch(50% 0.15 200)',
            'info-text' => 'oklch(100% 0 0)',
            'base' => [
                'text' => 'oklch(15% 0.05 140)',
                'stroke' => 'oklch(50% 0.08 140)',
                'default' => 'oklch(95% 0.02 140)',
                50 => 'oklch(95% 0.02 140)',
                100 => 'oklch(90% 0.04 140)',
                200 => 'oklch(85% 0.06 140)',
                300 => 'oklch(80% 0.08 140)',
                400 => 'oklch(70% 0.12 140)',
                500 => 'oklch(60% 0.15 140)',
                600 => 'oklch(50% 0.18 140)',
                700 => 'oklch(40% 0.15 140)',
                800 => 'oklch(30% 0.12 140)',
                900 => 'oklch(20% 0.08 140)',
            ]
        ];
    }

    public function getDarkColors(): array
    {
        return [
            'body' => 'oklch(12% 0.05 140)',
            'primary' => 'oklch(55% 0.2 140)',
            'primary-text' => 'oklch(100% 0 0)',
            'secondary' => 'oklch(45% 0.15 140)',
            'secondary-text' => 'oklch(100% 0 0)',
            'success' => 'oklch(60% 0.18 140)',
            'success-text' => 'oklch(100% 0 0)',
            'warning' => 'oklch(65% 0.12 85)',
            'warning-text' => 'oklch(10% 0.05 140)',
            'error' => 'oklch(55% 0.18 25)',
            'error-text' => 'oklch(100% 0 0)',
            'info' => 'oklch(55% 0.15 200)',
            'info-text' => 'oklch(100% 0 0)',
            'base' => [
                'text' => 'oklch(90% 0.02 140)',
                'stroke' => 'oklch(70% 0.08 140)',
                'default' => 'oklch(15% 0.05 140)',
                50 => 'oklch(10% 0.03 140)',
                100 => 'oklch(15% 0.05 140)',
                200 => 'oklch(20% 0.07 140)',
                300 => 'oklch(25% 0.08 140)',
                400 => 'oklch(35% 0.12 140)',
                500 => 'oklch(45% 0.15 140)',
                600 => 'oklch(55% 0.18 140)',
                700 => 'oklch(65% 0.15 140)',
                800 => 'oklch(75% 0.12 140)',
                900 => 'oklch(85% 0.08 140)',
            ]
        ];
    }
}
