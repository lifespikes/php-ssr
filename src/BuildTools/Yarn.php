<?php

namespace LifeSpikes\SSR\Tools;

use LifeSpikes\SSR\Enums\Signal;
use LifeSpikes\SSR\Terminal\Process;
use LifeSpikes\SSR\Contracts\PackageManager;
use LifeSpikes\SSR\Enums\InstallType;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

class Yarn implements PackageManager
{
    public function __construct(
        protected Process $yarn = new Process('yarn'),
        protected PackageManifest $manifest = new PackageManifest(),
    ) {
    }

    /**
     * @throws NodeInstanceException
     */
    public function add(string $package, string $version = null, InstallType $type = InstallType::DEV): Signal
    {
        if ($this->manifest->has($package)) {
            return Signal::NOOP;
        }

        $pkg = $version ? "$package@$version" : $package;

        $this->yarn('add', $type === InstallType::DEV ? '-D' : null, $pkg);
        return Signal::OK;
    }

    /**
     * @throws NodeInstanceException
     */
    public function initialize(): Signal
    {
        if (!file_exists(SSR_APP_ROOT . '/package.json')) {
            $this->yarn('init', '-y');
            return Signal::OK;
        }

        return Signal::NOOP;
    }

    /**
     * @throws NodeInstanceException
     */
    public function install(InstallType $type = InstallType::DEV): Signal
    {
        $this->setNodeEnv($type)->yarn('install');
        return Signal::OK;
    }

    /**
     * @param mixed ...$args
     * @throws NodeInstanceException
     */
    private function yarn(...$args): void
    {
        $exec = ($this->yarn)(...$args);
        print $exec->output . PHP_EOL;
    }

    /**
     * @param InstallType $type
     * @return Yarn
     */
    private function setNodeEnv(InstallType $type): Yarn
    {
        $env = match ($type) {
            InstallType::PROD => 'production',
            default => 'development',
        };

        putenv("NODE_ENV=$env");

        return $this;
    }
}
