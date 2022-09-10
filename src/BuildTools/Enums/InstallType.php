<?php

namespace LifeSpikes\SSR\Enums;

enum InstallType: string
{
    case DEV    = 'devDependencies';
    case PROD   = 'dependencies';
    case ANY    = 'any';
}
