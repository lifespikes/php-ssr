<?php

namespace LifeSpikes\SSR\Contracts;

use LifeSpikes\SSR\Enums\Signal;
use LifeSpikes\SSR\Enums\InstallType;
use LifeSpikes\SSR\Tools\PackageManifest;

interface PackageManager
{
    /**
     * Initialize files required for the package manager.
     * @return Signal
     */
    public function initialize(): Signal;

    /**
     * Install a package using the package manager.
     *
     * @param string $package Package name
     * @param string|null $version Version constraint
     * @param InstallType $type
     * @return Signal
     */
    public function add(string $package, string $version = null, InstallType $type = InstallType::DEV): Signal;

    /**
     * Install all dependencies using the package manager.
     *
     * @param InstallType $type
     * @return Signal
     */
    public function install(InstallType $type = InstallType::DEV): Signal;

    /**
     * @return PackageManifest
     */
    public function manifest(): PackageManifest;
}
