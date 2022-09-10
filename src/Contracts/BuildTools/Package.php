<?php

namespace LifeSpikes\SSR\Contracts\BuildTools;

use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\BuildTools\Enums\InstallType;

interface Package
{
    public function name(): string;

    public function version(): string|null;

    public function type(): InstallType;

    public function afterInstall(Application $application): void;
}
