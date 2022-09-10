<?php

namespace LifeSpikes\SSR\BuildTools;

use LifeSpikes\SSR\BuildTools\Enums\InstallType;

class PackageManifest
{
    /**
     * @var array<mixed>
     */
    protected array $manifest;

    public function __construct()
    {
        $this->manifest = file_exists($mp = SSR_APP_ROOT.'/package.json')
            ? json_decode(file_get_contents($mp), true)
            : [];
    }

    /**
     * Check presence of a package in the package.json manifest.
     */
    public function has(string $package, string $version = null, InstallType $type = InstallType::ANY): bool
    {
        $m = $this->manifest;

        $deps = $type === InstallType::ANY ? [
           ...$m['dependencies'] ?? [],
           ...$m['devDependencies'] ?? []
        ] : $m[$type->value] ?? [];

        return isset($deps[$package]) && ($version === null || $deps[$package] === $version);
    }
}
