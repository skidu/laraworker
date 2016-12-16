<?php
namespace Skidu\LaraWorker\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    protected $logFile;
    protected $pidFile;
    protected $runConfFile;

    protected function loadRuntimeConfig()
    {
        if(!$this->runConfFile) {
            $this->initRunConfFile();
        }
        $config = json_decode(file_get_contents($this->runConfFile));
        if(json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception('parse runtime config failed: ' . $this->runConfFile);
        }

        $this->logFile = $config->log;
        $this->pidFile = $config->pid;
        return true;
    }

    protected function initLogFile($logFile=null)
    {
        if (!$logFile) {
            $logFile = config('workerman.log_file') .DIRECTORY_SEPARATOR. 'workerman.log';
        }
        $this->createRunFile($logFile, 'log file');
        $this->logFile = $logFile;
        return true;
    }

    protected function initPidFile($pidFile=null)
    {
        if (!$pidFile) {
            $pidFile = config('workerman.pid_file') .DIRECTORY_SEPARATOR. 'workerman.pid';
        }
        $this->createRunFile($pidFile, 'pid file');
        $this->pidFile = $pidFile;
        return true;
    }

    protected function initRunConfFile()
    {
        $runConfFile = config('workerman.run_conf');
        $this->createRunFile($runConfFile, 'runtime config file');
        $this->runConfFile = $runConfFile;
        return true;
    }

    private function createRunFile($file, $type)
    {
        $directory = dirname($file);
        if (!is_dir($directory) && !mkdir($directory)) {
            throw new \Exception("can not create directory: {$directory}");
        }
        if (!is_file($file) && ! touch($file)) {
            throw new \Exception("create {$type} failed: {$file}");
        }
        if (!is_writable($file)) {
            throw new \Exception("{$type} can not been written: {$file}");
        }

        return true;
    }
}
