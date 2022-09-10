<?php

namespace LifeSpikes\SSR\BuildTools\Commands;

use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\BuildTools\Enums\Signal;
use Symfony\Component\Console\Command\Command;
use LifeSpikes\SSR\BuildTools\Enums\InstallType;
use LifeSpikes\SSR\Contracts\BuildTools\Package;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

#[AsCommand(name: 'dependencies')]
class InstallDependencies extends Command
{
    protected static $defaultDescription = 'Install and verify frontend dependencies for PHP-SSR';

    protected Application $application;

    public function __construct(Application $application)
    {
        parent::__construct();

        $this->application = $application;
    }

    /**
     * @throws NodeInstanceException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $manager = $this->application->packageManager;
        $dependencies = $this->application->dependencies;

        if ($manager->initialize() === Signal::NOOP) {
            $output->writeln('Yarn project already initialized');
        }

        foreach ($dependencies as $dependency) {
            [$package, $version, $type, $instance] = $this->getPackage($dependency);
            $output->writeln("Installing - $package@$version");

            $manager->add($package, $version, $type) === Signal::OK
                ? $output->writeln("Added - $package@$version")
                : $output->writeln("Already installed - $package@$version");

            $instance->afterInstall($manager);
        }

        return Command::SUCCESS;
    }

    /**
     * @param string $packageClass
     * @return array{string, string, InstallType, Package}
     */
    private function getPackage(string $packageClass): array
    {
        /**
         * @var Package $dep
         */
        $dep = new $packageClass();
        return [$dep->name(), $dep->version(), $dep->type(), $dep];
    }
}
