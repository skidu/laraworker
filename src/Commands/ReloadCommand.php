<?php
namespace Skidu\LaraWorker\Commands;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;
use Workerman\Worker;

class ReloadCommand extends BaseCommand
{
    protected $signature = 'worker:reload';
    protected $description = 'reload all workerman apps';

    public function fire()
    {
        $this->loadRuntimeConfig();

        global $argv;
        $argv = array('artisan', 'reload');

        Worker::$pidFile = $this->pidFile;
        Worker::$logFile = $this->logFile;
        Worker::runAll();
    }

}
