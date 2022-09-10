<?php

namespace LifeSpikes\SSR\Contracts;

use LifeSpikes\SSR\Enums\InstallType;

interface Package
{
    public function name(): string;

    public function version(): string;

    public function type(): InstallType;

    public function afterInstall(PackageManager $packageManager): void;
}
