<?php

declare(strict_types=1);

namespace BombenProdukt\BladeIcons;

use Illuminate\Support\Facades\Blade;
use BombenProdukt\BladeIcons\Exceptions\IconFamilyException;
use BombenProdukt\BladeIcons\Facades\IconFamilyRegistry;
use BombenProdukt\BladeIcons\View\Components\Icon;

final class ComponentRegistrar
{
    public function register(string $family): void
    {
        $parent = IconFamilyRegistry::findByName($family);

        if (empty($parent)) {
            throw IconFamilyException::missing($family);
        }

        /** @var IconFamilyStyle */
        foreach ($parent->styles() as $style) {
            foreach ($style->icons() as $icon) {
                Blade::component(Icon::class, $icon, $parent->prefix().':'.$style->prefix());
            }
        }
    }
}
