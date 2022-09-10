<?php

namespace LifeSpikes\SSR\BuildTools\Commands;

use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\BuildTools\Enums\Signal;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

#[AsCommand(
    name: 'dependencies',
    description: 'Install and verify frontend dependencies for PHP-SSR'
)]
class InstallDependencies extends Command
{
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

        $output->writeln('Installing dependencies...');
        $manager->addMany(array_map(function (string $dependency) {
            return [
                'package' => ($instance = new $dependency())->name(),
                'version' => $instance->version()
            ];
        }, $dependencies));

        $output->writeln('Verifying dependencies...');
        foreach ($dependencies as $dependency) {
            (new $dependency())->afterInstall($this->application);
        }

        return Command::SUCCESS;
    }
}
