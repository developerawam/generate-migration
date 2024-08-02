<?php

namespace Developerawam\GenerateMigration;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Developerawam\GenerateMigration\Skeleton\SkeletonClass
 */
class GenerateMigrationFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'generate-migration';
    }
}
