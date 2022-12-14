<?php

namespace LifeSpikes\SSR\BuildTools\Packages;

use Closure;
use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\BuildTools\Process;
use LifeSpikes\SSR\BuildTools\Enums\InstallType;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;
use LifeSpikes\SSR\Contracts\BuildTools\Package as PackageContract;

class Package implements PackageContract
{
    public string $name;
    public string|null $version = null;
    public InstallType $type = InstallType::DEV;

    public function name(): string
    {
        return $this->name;
    }

    public function version(): string|null
    {
        return $this->version;
    }

    public function type(): InstallType
    {
        return $this->type;
    }

    public function afterInstall(Application $application): void
    {
    }

    /**
     * @return array{compilerOptions: array<string, mixed>, include: array<string, mixed>}
     * @throws NodeInstanceException
     */
    protected function checkTsConfig(): array
    {
        $process = new Process('tsc');
        return $process('--showConfig')->output;
    }

    /**
     * @param Application $application
     * @param Closure $diagnoseFn
     * @return string[]
     * @throws NodeInstanceException
     */
    protected function typeScriptDiagnose(Application $application, Closure $diagnoseFn): array
    {
        if ($application->packageManager->manifest()->has('typescript')) {
            $config = $this->checkTsConfig();
            $opts = $config['compilerOptions'];

            return array_filter($diagnoseFn($opts), fn ($i) => $i !== null);
        }

        return [];
    }
}
