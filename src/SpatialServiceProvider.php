<?php

namespace Limenet\LaravelMysqlSpatial;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\DatabaseServiceProvider;
use Limenet\LaravelMysqlSpatial\Connectors\ConnectionFactory;

/**
 * Class DatabaseServiceProvider.
 */
class SpatialServiceProvider extends DatabaseServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register(): void
    {
        parent::register();

        // The connection factory is used to create the actual connection instances on
        // the database. We will inject the factory into the manager so that it may
        // make the connections while they are actually needed and not of before.
        $this->app->singleton('db.factory', fn ($app) => new ConnectionFactory($app));

        // The database manager is used to resolve various connections, since multiple
        // connections might be managed. It also implements the connection resolver
        // interface which may be used by other components requiring connections.
        $this->app->singleton('db', fn ($app) => new DatabaseManager($app, $app['db.factory']));
    }
}
