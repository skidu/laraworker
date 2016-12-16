<?php
namespace Skidu\LaraWorker\Commands;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;
use Workerman\Worker;

class StartCommand extends BaseCommand
{
    protected $signature = 'worker:start {--daemon} {--logfile=} {--pidfile=}';
    protected $description = 'start all workerman apps';

    public function fire()
    {
        $this->checkExtensions();
        $this->initLogFile($this->option('logfile'));
        $this->initPidFile($this->option('pidfile'));
        $this->initRunConfFile();
        $this->initWorkspace();
        $this->startWorker();
    }

    protected function checkExtensions()
    {
        if (!extension_loaded('pcntl')) {
            throw new \Exception("Please install pcntl extension");
        }
        if (!extension_loaded('posix')) {
            throw new \Exception("Please install posix extension");
        }
        return true;
    }

    protected function initWorkspace()
    {
        $daemonOption  = $this->option('daemon') ? '-d' : '';
        global $argv;
        $argv = array(
            'artisan',
            'start',
            $daemonOption
        );

        define('GLOBAL_START', 1);
        Worker::$pidFile = $this->pidFile;
        Worker::$logFile = $this->logFile;
        return true;
    }

    protected function startWorker() 
    {
        $appPath = config('workerman.app_path');
        $apps    = config('workerman.apps');
        foreach ($apps as $appName => $appConfig) {
            $file = $appPath .DIRECTORY_SEPARATOR. ucfirst($appName) .DIRECTORY_SEPARATOR. 'start.php';
            if (!is_file($file)) {
                return $this->error("can not start app: {$appName}");
            }
            require_once $file;
        }
        $config = array(
            'pid' => $this->pidFile,
            'log' => $this->logFile
        );
        file_put_contents($this->runConfFile, json_encode($config));
        Worker::runAll();
    }
}
