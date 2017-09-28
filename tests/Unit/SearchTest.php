<?php

namespace Tests\Unit;

use App\models\Index\Goods;
use App\models\Index\Objects;


/**
 * Class SearchTest
 * @package Tests\Unit
 *
 * @note Launch from docroot: `./vendor/bin/phpunit` OR `./vendor/bin/phpunit tests/Unit/SearchTest.php`
 */
class SearchTest extends \PHPUnit\Framework\TestCase
{
    protected static $app;

    /**
     * @return void
     */
    public static function setUpBeforeClass()
    {
        self::$app = require dirname(dirname(__DIR__)) . '/bootstrap/app.php';
        self::$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    }

    /**
     * @return void
     */
    public function testElasticsearch()
    {
        $this->assertTrue(Goods::getClient()->ping());
    }

    /**
     * @return void
     */
    public function testGoods()
    {
        /**
         * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
         */
        $result = Goods::search([
            'query' => [
                'match' => [
                    'goods_cod_name' => 'C00090554'
                ]
            ],
            'from' => 0,//offset
            'size' => 1,//limit
            'sort' => [
                'goods_sort' => ['order' => 'desc']//sorting
            ]
        ]);

        $this->assertNotEmpty($result);

        $result = Goods::search([
            'query' => [
                'match' => [
                    'goods_keywords' => 'whirlpool'
                ]
            ],
            'from' => 0,//offset
            'size' => 1,//limit
            'sort' => [
                'goods_sort' => ['order' => 'desc']//sorting
            ]
        ]);

        $this->assertNotEmpty($result);
    }

    /**
     * @return void
     */
    public function testObjects()
    {
        /**
         * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-match-query.html
         */
        $result = Objects::search([
            'query' => [
                'match' => [
                    'object_name_name' => 'Пользователь'
                ]
            ],
            'from' => 0,//offset
            'size' => 5,//limit
            'sort' => [
                '_score' => ['order' => 'desc']//sorting (relevance)
            ]
        ]);

        $this->assertNotEmpty($result);

        /**
         * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-query-string-query.html
        */
        $result = Objects::search([
            'query' => [
                'query_string' => [
                    'fields' => ['object_name_name'],
                    'query'  => 'Conditions OR Условия',
                ]
            ],
            'from' => 0,//offset
            'size' => 5,//limit
            'sort' => [
                '_score' => ['order' => 'desc']//sorting (relevance)
            ],
        ]);

        $this->assertNotEmpty($result);
    }
}
