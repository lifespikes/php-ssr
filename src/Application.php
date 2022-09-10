<?php

namespace LifeSpikes\SSR;

use Exception;
use LifeSpikes\SSR\BuildTools\Yarn;
use LifeSpikes\SSR\BuildTools\Packages\React;
use LifeSpikes\SSR\BuildTools\Packages\Parcel;
use LifeSpikes\SSR\BuildTools\Packages\Package;
use LifeSpikes\SSR\BuildTools\Packages\TypeScript;
use LifeSpikes\SSR\Contracts\BuildTools\PackageManager;
use Symfony\Component\Console\Application as ConsoleApplication;

class Application
{
    /**
     * @var class-string<Package>[] FQDNs of packages to install
     */
    public array $dependencies = [];

    public function __construct(
        public ConsoleApplication $console = new ConsoleApplication(),
        public PackageManager $packageManager = new Yarn(),
    ) {
        $this->dependencies = [TypeScript::class, React::class, Parcel::class];
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
