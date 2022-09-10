<?php

namespace LifeSpikes\SSR\BuildTools;

use LifeSpikes\PHPNode\Instance;
use LifeSpikes\PHPNode\FinishedProcess;
use LifeSpikes\SSR\BuildTools\Exceptions\BinaryNotFoundException;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

class Process
{
    /**
     * @var string Path to the binary being executed.
     */
    protected string $path;

    /**
     * Verify that the binary exists and is executable.
     * @throws BinaryNotFoundException
     */
    public function __construct(public string $file)
    {
        $this->path = realpath(file_exists($file) ? $file : $this->findInPath($file));

        if (!$this->path || !is_executable($this->path)) {
            throw new BinaryNotFoundException("Unable to spawn process: `{$file}` not found");
        }
    }

    /**
     * Executes the process with provided arguments.
     * @param array<mixed> $args
     * @throws NodeInstanceException
     */
    public function __invoke(...$args): FinishedProcess
    {
        $bin = new Instance($this->path, $args);
        return $bin->run();
    }

    /**
     * @param string $program
     * @return string Absolute path to binary based on system PATH
     */
    protected function findInPath(string $program): string
    {
        return exec("which $program");
    }
}
