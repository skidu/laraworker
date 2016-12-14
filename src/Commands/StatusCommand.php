<?php
namespace Skidu\LaraWorker\Commands;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;
use Workerman\Worker;

class StatusCommand extends BaseCommand
{
    protected $signature = 'worker:status';
    protected $description = 'show all workerman app status';

    public function fire()
    {
        $this->loadRuntimeConfig();

        global $argv;
        $argv = array(
            'artisan', 'status'
        );
        Worker::$logFile = $this->logFile;
        Worker::$pidFile = $this->pidFile;
        Worker::runAll();
    }
}
