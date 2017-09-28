<?php

namespace App\Console\Commands;

use App\Handlers\ElasticsearchIndexer;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class SearchIndex
 * @package App\Console\Commands
 *
 * @run `php artisan search:index` OR `php artisan search:index 10`
 */
class SearchIndex extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Elasticsearch indexes';

    /**
     * @return void
     */
    protected function configure()
    {
        $this->addArgument('limit', InputArgument::OPTIONAL, 'Limit of records that will be indexed (no value - means that all records will be indexed)');
        $this->addArgument('iterateLimit', InputArgument::OPTIONAL, 'Limit of records for one batch inserting');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ( ! \App::isLocal()) {
            return;
        }

        //Attention!!  be careful. Indexes will be rebuilded

        $params = [];
        //limit means count of records that should be indexed
        if ($this->argument('limit')) {
            $params['limit'] = $this->argument('limit');
        }
        if ($this->argument('iterateLimit')) {
            $params['iterateLimit'] = $this->argument('iterateLimit');
        }


        //index Goods
        $this->info('Start indexing Goods...');
        ElasticsearchIndexer::indexGoods($params);
        $this->info('Finish indexing Goods.');

        //index Objects
        $this->info('Start indexing Objects...');
        ElasticsearchIndexer::indexObjects($params);
        $this->info('Finish indexing Objects.');
    }
}
