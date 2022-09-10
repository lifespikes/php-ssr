<?php

namespace LifeSpikes\SSR\BuildTools\Commands;

use LifeSpikes\SSR\Application;
use Symfony\Component\Console\Command\Command;
use LifeSpikes\SSR\Contracts\BuildTools\Curable;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'diagnose',
    description: 'Diagnose issues with enabled dependencies'
)]
class DiagnoseDependencies extends Command
{
    protected Application $application;

    public function __construct(Application $application)
    {
        parent::__construct();

        $this->application = $application;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        foreach ($this->application->dependencies as $dependency) {
            $dependency = new $dependency();

            if ($dependency instanceof Curable) {
                foreach ($dependency->diagnose($this->application) as $message) {
                    $output->writeln(get_class($dependency).': '.$message);
                }
            }
        }

        return Command::SUCCESS;
    }
}
