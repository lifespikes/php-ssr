<?php

namespace LifeSpikes\SSR\BuildTools\Packages;

use JsonException;
use LifeSpikes\SSR\Application;
use LifeSpikes\SSR\Contracts\BuildTools\Curable;
use LifeSpikes\PHPNode\Exceptions\NodeInstanceException;

class Parcel extends Package implements Curable
{
    public string $name = 'parcel';

    /**
     * @throws NodeInstanceException
     * @throws JsonException
     */
    public function diagnose(Application $application): array
    {
        return $this->typeScriptDiagnose($application, function (array $opts) {
            return [
                $opts['isolatedModules'] !== true ? 'isolatedModules is not set to true' : null,
                isset($opts['baseUrl']) ? 'baseUrl is set, but not supported by Parcel' : null,
                isset($opts['paths']) ? 'paths is set, but not supported by Parcel' : null
            ];
        });
    }
}
