<?php

namespace LifeSpikes\SSR\Layout;

class Component
{
    /**
     * @var array<string, mixed>
     */
    public array $props = [];

    /**
     * @param string $component
     * @param array<string, mixed> $props
     */
    public function __construct(
        public string $component,
        array $props = []
    ) {
        $this->props = $props;
    }

    public function setProp(string $prop, mixed $value): void
    {
        $this->props[$prop] = $value;
    }
}
