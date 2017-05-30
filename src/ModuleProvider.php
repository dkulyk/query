<?php
declare(strict_types=1);

namespace DKulyk\Eloquent\Query;

use DKulyk\Eloquent\Query\Contracts\QueryManager;
use Illuminate\Support\ServiceProvider;

/**
 * Class ModuleProvider
 *
 * @package DKulyk\Eloquent\Query
 */
class ModuleProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(QueryManager::class, function () {
            return new Manager;
        });

        $this->app->alias(QueryManager::class, Manager::class);
    }
}
