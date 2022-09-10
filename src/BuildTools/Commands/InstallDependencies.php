<?php

namespace LifeSpikes\SSR\BuildTools\Commands;

use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\Enums\Signal;
use LifeSpikes\SSR\Contracts\PackageManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

#[AsCommand(name: 'dependencies')]
class InstallDependencies extends Command
{
    protected static $defaultDescription = 'Install and verify frontend dependencies for PHP-SSR';

    protected PackageManager $manager;

    /**
     * @var array<int, string[]>
     */
    protected array $dependencies;

    public function __construct(Application $application)
    {
        parent::__construct();
        $this->manager = $application->packageManager;
        $this->dependencies = [
            ['react', '^18.2.0'],
            ['chokidar', '^3.5.3']
        ];
    }

    /**
     * @throws NodeInstanceException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($this->manager->initialize() === Signal::NOOP) {
            $output->writeln('Yarn project already initialized');
        }

        foreach ($this->dependencies as [$package, $version]) {
            $output->writeln("Installing - $package@$version");

            $this->manager->add($package, $version) === Signal::OK
                ? $output->writeln("Added - $package@$version")
                : $output->writeln("Already installed - $package@$version");
        }

        return Command::SUCCESS;
    }
}
