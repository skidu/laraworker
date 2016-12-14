<?php
namespace Skidu\LaraWorker\Commands;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;
use Workerman\Worker;

class RestartCommand extends BaseCommand
{
    protected $signature = 'worker:restart {--daemon}';
    protected $description = 'restart all workerman apps';

    public function fire()
    {
        $this->loadRuntimeConfig();
        global $argv;
        $argv = array(
            'artisan',
            'restart',
            $this->option('daemon') ? '-d' : ''
        );

        define('GLOBAL_START', 1);

        Worker::$logFile = $this->logFile;
        Worker::$pidFile = $this->pidFile;
        Worker::runAll();
    }
}
