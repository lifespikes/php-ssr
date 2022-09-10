<?php

namespace LifeSpikes\SSR;

use LifeSpikes\SSR\Layout\Component;

/**
 * @param string $component
 * @param array<string, mixed> $props
 * @return Component
 */
function component(string $component, array $props = []): Component
{
    return new Component($component, $props);
}
