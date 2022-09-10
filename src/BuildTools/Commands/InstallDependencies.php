<?php

namespace LifeSpikes\SSR\BuildTools\Commands;

use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\Enums\Signal;
use LifeSpikes\SSR\Tools\TypeScript;
use LifeSpikes\SSR\Contracts\Package;
use LifeSpikes\SSR\Contracts\PackageManager;
use LifeSpikes\SSR\BuildTools\Packages\React;
use Symfony\Component\Console\Command\Command;
use LifeSpikes\SSR\BuildTools\Packages\Parcel;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

#[AsCommand(name: 'dependencies')]
class InstallDependencies extends Command
{
    protected static $defaultDescription = 'Install and verify frontend dependencies for PHP-SSR';

    /**
     * @var PackageManager
     */
    protected PackageManager $manager;

    /**
     * @var string[]
     */
    protected array $dependencies;

    public function __construct(Application $application)
    {
        parent::__construct();

        $this->manager = $application->packageManager;
        $this->dependencies = [TypeScript::class, React::class, Parcel::class];
    }

    /**
     * @throws NodeInstanceException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->manager->initialize() === Signal::NOOP) {
            $output->writeln('Yarn project already initialized');
        }

        foreach ($this->dependencies as $dependency) {
            [$package, $version] = $this->getPackage($dependency);
            $output->writeln("Installing - $package@$version");

            $this->manager->add($package, $version) === Signal::OK
                ? $output->writeln("Added - $package@$version")
                : $output->writeln("Already installed - $package@$version");
        }

        return Command::SUCCESS;
    }

    /**
     * @param string $packageClass
     * @return array<string>
     */
    private function getPackage(string $packageClass): array
    {
        /**
         * @var Package $dep
         */
        $dep = new $packageClass();

        return [$dep->name(), $dep->version()];
    }
}
