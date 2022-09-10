<?php

namespace LifeSpikes\SSR\BuildTools\Packages;

use LifeSpikes\SSR\Enums\InstallType;
use LifeSpikes\SSR\BuildTools\Process;
use LifeSpikes\PHPNode\FinishedProcess;
use LifeSpikes\SSR\Contracts\PackageManager;
use LifeSpikes\SSR\Contracts\Package as PackageContract;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

class Package implements PackageContract
{
    public string $name;
    public string|null $version = null;
    public InstallType $type = InstallType::DEV;

    public function name(): string
    {
        return $this->name;
    }

    public function version(): string
    {
        return $this->version;
    }

    public function type(): InstallType
    {
        return $this->type;
    }

    public function afterInstall(PackageManager $packageManager): void
    {
    }

    /**
     * @throws NodeInstanceException
     */
    protected function checkTsConfig(): FinishedProcess
    {
        $process = new Process('tsc');
        return $process('--showConfig');
    }
}
