<?php

namespace LifeSpikes\SSR;

use Exception;
use LifeSpikes\SSR\Tools\Yarn;
use LifeSpikes\SSR\Contracts\PackageManager;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application
{
    public function __construct(
        public ConsoleApplication $console = new ConsoleApplication(),
        public PackageManager $packageManager = new Yarn()
    ) {
    }

    /**
     * @param array{watch: string[]} $config
     * @return void
     */
    public function run(array $config)
    {

    }

    /**
     * Initialize Symfony Console application.
     * @throws Exception
     */
    public function terminal(): void
    {
        $this->console->run();
    }
}
