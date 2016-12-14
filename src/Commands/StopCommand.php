<?php
namespace Skidu\LaraWorker\Commands;

use Workerman\Worker;

class StopCommand extends BaseCommand
{
    protected $signature = 'worker:stop';
    protected $description = 'stop all workerman apps';

    public function fire()
    {
        $this->loadRuntimeConfig();

        global $argv;
        $argv = array(
            'artisan',
            'stop',
        );
        Worker::$logFile = $this->logFile;
        Worker::$pidFile = $this->pidFile;
        Worker::runAll();

        unlink($this->runConfFile);
    }
}
