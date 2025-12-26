<?php

namespace App\Providers;

use App\Models\DomainService;
use App\Models\HostingService;
use App\Queue\UuidDatabaseQueue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Queue;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Relation::enforceMorphMap([
            'hosting' => HostingService::class,
            'domain' => DomainService::class,
        ]);

        Queue::extend('uuid-database', function ($app) {
            $config = $app['config']['queue.connections.database'];

            return new UuidDatabaseQueue(
                $app['db']->connection($config['connection'] ?? null),
                $config['table'],
                $config['queue'] ?? 'default',
                $config['retry_after'] ?? 90,
                $config['after_commit'] ?? false
            );
        });
    }
}
