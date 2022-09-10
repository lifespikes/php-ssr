<?php

namespace LifeSpikes\SSR\BuildTools\Packages;

use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\Enums\InstallType;
use LifeSpikes\SSR\Contracts\Curable;
use LifeSpikes\SSR\Contracts\PackageManager;

class Parcel extends Package implements Curable
{
    public string $name = 'parcel';

    public function diagnose(Application $application): array
    {
        // TODO: Implement diagnose() method.
    }
}
