<?php

namespace LifeSpikes\SSR\Contracts\BuildTools;

use LifeSpikes\SSR\BuildTools\Enums\InstallType;

interface Package
{
    public function name(): string;

    public function version(): string;

    public function type(): InstallType;

    public function afterInstall(PackageManager $packageManager): void;
}
