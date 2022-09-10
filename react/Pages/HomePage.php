<?php

namespace LifeSpikes\SSRExample;

class HomePage
{
    public function render(): string
    {
        return component('Page', [
        ]);
    }

    public function children()
    {
        return [
            component('Navbar', [
                'onClick' => function (Component $navbar, Arguments $args) {
                    $navbar->setProp('active', $args[0]);
                }
            ]),

            component('Table')
        ];
    }
}
