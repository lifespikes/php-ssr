<?php

namespace LifeSpikes\SSR\BuildTools\Enums;

enum InstallType: string
{
    case DEV    = 'devDependencies';
    case PROD   = 'dependencies';
    case ANY    = 'any';
}
