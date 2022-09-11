<?php

namespace LifeSpikes\SSR\Contracts\BuildTools;

use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\BuildTools\Enums\InstallType;

interface Package
{
    /**
     * @return string Package name as it appears on the registry
     */
    public function name(): string;

    /**
     * @return string|null Version constraint, or null if latest compatible version
     */
    public function version(): string|null;

    /**
     * @return InstallType Specify if this is a dev or production dependency
     */
    public function type(): InstallType;

    /**
     * Executes after installation of a package, or installation of many
     * packages.
     * @param Application $application
     * @return void
     */
    public function afterInstall(Application $application): void;
}
