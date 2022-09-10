<?php

namespace LifeSpikes\SSR\Contracts\BuildTools;

use LifeSpikes\SSR\Application;

interface Curable
{
    /**
     * Output an array of potential errors.
     * @return array<string>
     */
    public function diagnose(Application $application): array;
}
