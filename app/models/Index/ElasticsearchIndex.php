<?php

namespace App\models\Index;



/**
 * Class BaseIndexModel
 * @package App\models\Index
 *
 * Class has easy-use interface with high-level declarations
 *
 * @link Based on https://www.elastic.co/guide/en/elasticsearch/client/php-api/5.0/index.html
 * @vendor https://github.com/elastic/elasticsearch-php
 */
class ElasticsearchIndex
{
    /**
     * One method for getting instance of Elasticsearch client from Provider (Created for the simpliest using)
     * @return \Elasticsearch\Client
     */
    public static function getClient()
    {
        return app()->make(\App\Providers\ElasticsearchServiceProvider::ELASTICSEARCH_CLIENT);
    }

    /**
     * @return string
     */
    public static function getIndexName()
    {
        return \Illuminate\Support\Facades\Config::get('elasticsearch.default_index');
    }

    /**
     * @return mixed
     */
    public static function getIndexType()
    {
        return static::getIndexName();
    }

    /**
     * @return array
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/5.0/_index_management_operations.html#_put_mappings_api
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/5.5/mapping.html
     */
    public static function getMappings()
    {
        return [
            static::getIndexType() => [
                '_source' => [
                    'enabled' => true
                ],
                'properties' => static::getMappingsProperties(),
            ]
        ];
    }

    /**
     * @return array
     */
    public static function getSettings()
    {
        return [];
    }

    /**
     * Low level with list of properties of mapping.
     * This method MUST BE redefined in extended instance and must return array!!!
     * @return array
     * @throws \Exception
     */
    protected static function getMappingsProperties()
    {
        throw new \Exception('This method MUST BE redefined in extended instance and must return array');
    }

    /**
     * Get uniq id value for `_id`
     * Each document in index requires unique `_id` value. In our case It is sha1 value
     * @return string
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/5.5/mapping-id-field.html
     */
    protected static function getUniqIdValue()
    {
        return sha1(uniqid() . time());
    }

    /**
     * Delete and create index
     *
     * Note: If you want to change mapping that consists of different types with real data in index -> you should create NEW index with actual mapping again
     *
     * @param bool|true $force
     * @return array|null
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_index_management_operations.html#_create_an_index
     */
    public static function rebuildIndex($force = true)
    {
        //if index exists...
        if (self::getClient()->indices()->exists(['index' => static::getIndexName()])) {
            //if you don't want delete-create index set `force` parameter in FALSE
            if (!$force) {
                return null;
            }
            //delete index
            self::getClient()->indices()->delete(['index' => static::getIndexName(),]);
        }

        //prepare body for creating index
        $body = [];
        //prepare index settings
        if (!empty(static::getSettings())) {
            $body['settings'] = static::getSettings();
        }
        //prepare mappings
        if (!empty(static::getMappings())) {
            $body['mappings'] = static::getMappings();
        }
        //create index and return array of statuses after creating
        return self::getClient()->indices()->create(['index' => static::getIndexName(), 'body'  => $body]);
    }


    /**
     * Complex saving to index
     *
     * @param array $data
     * @param array $params
     * @return array
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_indexing_documents.html#_bulk_indexing
     */
    public static function bulkInsert(array $data, $params = [])
    {
        //use default random primary key for elastic document OR get primary key from item of $data
        $dataId = array_get($params, '_id', null);

        $bulkParams = [];
        foreach ($data as $item) {
            $bulkParams['body'][] = [
                'index' => [
                    '_id' => ($dataId) ? array_get($item, $dataId) : static::getUniqIdValue(),
                    '_type' => static::getIndexType(),
                    '_index' => static::getIndexName()
                ],
            ];
            $bulkParams['body'][] = static::mapPropertiesKeysValues((array)$item);
        }
        // The same operation as Batch Insert
        return self::getClient()->bulk($bulkParams);
    }

    /**
     * @param array $body
     * Example for query dsl match operation (means search in both "testField AND testField2"):
     * [
     *   'query' => [
     *       'bool' => [
     *           'must' => [
     *               [ 'match' => [ 'testField' => 'abc' ] ],
     *               [ 'match' => [ 'testField2' => 'xyz' ] ],
     *           ]
     *       ]
     *   ]
     * ]
     * @param array $params
     * @return array
     *
     *
     * @see https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/_search_operations.html (examples of search operations)
     * @see https://github.com/elastic/elasticsearch-php/issues/135 (Easy example ow to get all data without `query`)
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl.html (You can send this queries via $body ANY)
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/5.5/search.html (One more way to send queries to Elastic)
     */
    public static function search($body, $params = [])
    {
        $response = static::getClient()->search([
            'index' => static::getIndexName(),
            'type'  => static::getIndexType(),
            'body'  => $body
        ]);

        //return full native request from elastic search OR only list of found Items
        return array_get($params, 'full', false) ? $response : array_get($response, 'hits', []);
    }

    /**
     * Helpful method.
     * Returns array of mapping properties with associated values (by keys) from input array.
     *
     * @param array $propertiesKeysValues
     * @return array  Returns associative array of ONLY mapping properties and their values
     */
    public static function mapPropertiesKeysValues(array $propertiesKeysValues)
    {
        //create array of mapping properties as keys and null values
        $propertiesValidKeys = array_flip(array_keys(static::getMappingsProperties()));
        $propertiesValidKeys = array_map(create_function('$n', 'return null;'), $propertiesValidKeys);
        //match mapping properties with input associative array. Returns array of mapping properties with associated values from input array.
        return array_intersect_key($propertiesKeysValues, $propertiesValidKeys);
    }

}