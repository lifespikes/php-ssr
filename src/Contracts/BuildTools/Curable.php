<?php

namespace LifeSpikes\SSR\Contracts;

use LifeSpikes\SSR\Application;

interface Curable
{
    /**
     * Output an array of potential errors.
     * @return array<string>
     */
    public function diagnose(Application $application): array;
}
