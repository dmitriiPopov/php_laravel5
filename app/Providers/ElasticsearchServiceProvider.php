<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder;

/**
 * Class ElasticsearchServiceProvider
 * @package App\Providers
 *
 * Provider for Elasticsearch services
 */
class ElasticsearchServiceProvider extends ServiceProvider
{
    //operate only with this constant ("hiding details")
    const ELASTICSEARCH_CLIENT = 'elasticsearch.client';

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(self::ELASTICSEARCH_CLIENT, function ($app) {
            return ClientBuilder::fromConfig(Config::get('elasticsearch.config'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [self::ELASTICSEARCH_CLIENT];
    }
}
