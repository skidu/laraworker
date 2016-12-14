<?php
namespace Skidu\LaraWorker\Commands;

use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Input\InputOption;

class CreateCommand extends BaseCommand
{
    protected $signature = 'worker:create {name}';
    protected $description = 'create a workerman apps';

    public function fire()
    {
        $name = $this->argument('name');
        $path = config('workerman.app_path');
        if (!is_dir($path) && !mkdir($path)) {
            return $this->error("\ncreate directory failed: {$path}\n");
        }

        $appPath = $path .DIRECTORY_SEPARATOR. ucfirst($name);
        if (is_dir($appPath)) {
            return $this->error("\nFile exists: {$appPath}\n");
        }

        if (!mkdir($appPath)) {
            return $this->error("\nfail to create directory at {$appPath}\n");
        }
    }
}
