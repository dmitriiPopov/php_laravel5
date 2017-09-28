<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ElasticsearchFacade
 * @package App\Facades
 */
class ElasticsearchFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return \App\Providers\ElasticsearchServiceProvider::ELASTICSEARCH_CLIENT;
    }
}