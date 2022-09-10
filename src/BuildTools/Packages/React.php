<?php

namespace LifeSpikes\SSR\BuildTools\Packages;

use JsonException;
use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\Contracts\BuildTools\Curable;
use LifeSpikes\SSR\Contracts\BuildTools\PackageManager;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

class React extends Package implements Curable
{
    public string $name = 'react';

    public function afterInstall(PackageManager $packageManager): void
    {
        foreach ([
            'react',
            'react-dom',
            ...($packageManager->manifest()->has('typescript') ? ['@types/react', '@types/react-dom'] : []),
        ] as $dependency) {
            $packageManager->add($dependency);
        }
    }

    /**
     * @throws NodeInstanceException
     * @throws JsonException
     */
    public function diagnose(Application $application): array
    {
        return $this->typeScriptDiagnose($application, function (array $opts) {
            return [
                $opts['jsx'] !== 'react-jsx' ? 'JSX is not set to react-jsx' : null,
                $opts['esModuleInterop'] !== true ? 'esModuleInterop is not set to true' : null,
                $opts['allowSyntheticDefaultImports'] !== true ? 'allowSyntheticDefaultImports is not set to true' : null,
                !in_array('dom', $opts['lib'] ?? []) ? 'DOM is not included in lib' : null,
                !in_array('dom.iterable', $opts['lib'] ?? []) ? 'DOM.iterable is not included in lib' : null,
            ];
        });
    }
}
