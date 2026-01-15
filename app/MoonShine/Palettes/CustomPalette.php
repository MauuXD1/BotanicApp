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
            'body' => 'oklch(82.32% 0.12332 140.319)',
            'primary' => 'oklch(34.84% 0.05469 163.393)',
            'primary-text' => 'oklch(0.00% 0 0)',
            'secondary' => 'oklch(0.00% 0 0)',
            'secondary-text' => 'oklch(0.00% 0 0)',
            'success' => 'oklch(0.00% 0 0)',
            'success-text' => 'oklch(0.00% 0 0)',
            'warning' => 'oklch(0.00% 0 0)',
            'warning-text' => 'oklch(0.00% 0 0)',
            'error' => 'oklch(0.00% 0 0)',
            'error-text' => 'oklch(0.00% 0 0)',
            'info' => 'oklch(0.00% 0 0)',
            'info-text' => 'oklch(0.00% 0 0)',
            'base' => [
                'text' => 'oklch(0.00% 0 0)',
                'stroke' => 'oklch(0.00% 0 0)',
                'default' => 'oklch(98.50% 0.00501 146.404)',
                50 => 'oklch(96.90% 0.016 293.756)',
                100 => 'oklch(95.00% 0.025 293.756)',
                200 => 'oklch(93.00% 0.045 293.756)',
                300 => 'oklch(90.00% 0.07 293.756)',
                400 => 'oklch(86.00% 0.11 293.756)',
                500 => 'oklch(77.00% 0.16 293.756)',
                600 => 'oklch(67.00% 0.2 293.756)',
                700 => 'oklch(58.00% 0.24 293.756)',
                800 => 'oklch(48.00% 0.19 293.756)',
                900 => 'oklch(38.00% 0.14 293.756)',
            ]
        ];
    }

    public function getDarkColors(): array
    {
        return [
            'body' => 'oklch(34.84% 0.05469 163.393)',
            'primary' => 'oklch(0.00% 0 0)',
            'primary-text' => 'oklch(0.00% 0 0)',
            'secondary' => 'oklch(38.53% 0.10372 23.287)',
            'secondary-text' => 'oklch(0.00% 0 0)',
            'success' => 'oklch(0.00% 0 0)',
            'success-text' => 'oklch(0.00% 0 0)',
            'warning' => 'oklch(0.00% 0 0)',
            'warning-text' => 'oklch(0.00% 0 0)',
            'error' => 'oklch(0.00% 0 0)',
            'error-text' => 'oklch(0.00% 0 0)',
            'info' => 'oklch(0.00% 0 0)',
            'info-text' => 'oklch(0.00% 0 0)',
            'base' => [
                'text' => 'oklch(0.00% 0 0)',
                'stroke' => 'oklch(0.00% 0 0)',
                'default' => 'oklch(0.00% 0 0)',
                50 => 'oklch(24.00% 0.05 293.756)',
                100 => 'oklch(29.00% 0.06 293.756)',
                200 => 'oklch(33.00% 0.07 293.756)',
                300 => 'oklch(39.00% 0.09 293.756)',
                400 => 'oklch(46.00% 0.12 293.756)',
                500 => 'oklch(54.00% 0.15 293.756)',
                600 => 'oklch(63.00% 0.17 293.756)',
                700 => 'oklch(72.00% 0.18 293.756)',
                800 => 'oklch(80.00% 0.15 293.756)',
                900 => 'oklch(87.00% 0.12 293.756)',
            ]
        ];
    }
}
