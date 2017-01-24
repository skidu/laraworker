<?php
namespace Skidu\LaraWorker\Commands;

class CreateCommand extends BaseCommand
{
    protected $signature = 'worker:create {name} {--type=1}';
    protected $description = 'create workerman app';

    public function fire()
    {
        $workerName = $this->argument('name');
        $config = config('workerman');
        $appPath = $config['app_path'];
        if (!is_dir($appPath) && !@mkdir($appPath)) {
            throw new \Exception("create app directory failed: {$appPath}");
        }

        $workspace = $appPath . DIRECTORY_SEPARATOR . ucfirst($workerName);
        if (is_dir($workspace)) {
            throw new \Exception("directory exists: {$workspace}");
        }
        if (!@mkdir($workspace)) {
            throw new \Exception("create app directory failed: {$workspace}");
        }

        $type = $this->option('type') == 1 ? 'Workerman' : 'GatewayWorker';
        $tpl = dirname(dirname(dirname(__FILE__))) .DIRECTORY_SEPARATOR.'examples' .DIRECTORY_SEPARATOR. $type .DIRECTORY_SEPARATOR. 'start.tpl';
        $content = str_replace('{AppName}', ucfirst($workerName), file_get_contents($tpl));
        file_put_contents($workspace.DIRECTORY_SEPARATOR.'start.php', $content);

        return true;
    }

}
