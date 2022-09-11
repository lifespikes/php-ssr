<?php

namespace LifeSpikes\SSR\Contracts\BuildTools;

use LifeSpikes\SSR\BuildTools\Enums\Signal;
use LifeSpikes\SSR\BuildTools\PackageManifest;
use LifeSpikes\SSR\BuildTools\Enums\InstallType;

interface PackageManager
{
    /**
     * Initialize anything required by the package manager
     * @return Signal
     */
    public function initialize(): Signal;

    /**
     * @param string $package Package name as it appears on the registry
     * @param string|null $version Version constraint or null if latest compatible version
     * @param InstallType $type Specify if this is a dev or production dependency
     * @return Signal
     */
    public function add(string $package, string $version = null, InstallType $type = InstallType::DEV): Signal;

    /**
     * @param array<int, array{package: string, version: string|null}> $packages Packages with versions to install
     * @param InstallType $type Add as a dev or production dependency
     * @return Signal
     */
    public function addMany(array $packages, InstallType $type = InstallType::DEV): Signal;

    /**
     * @param InstallType $type Should we include dev dependencies?
     * @return Signal
     */
    public function install(InstallType $type = InstallType::DEV): Signal;

    /**
     * @return PackageManifest Current package manifest
     */
    public function manifest(): PackageManifest;
}
