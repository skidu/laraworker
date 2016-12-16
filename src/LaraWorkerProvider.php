<?php
namespace Skidu\LaraWorker;

use Illuminate\Support\ServiceProvider;

class LaraWorkerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCmdCreate();
        $this->registerCmdStart();
        $this->registerCmdRestart();
        $this->registerCmdStop();
        $this->registerCmdReload();
        $this->registerCmdStatus();
    }

    protected function registerCmdCreate()
    {
        $this->app->singleton('command.worker.create', function($app){
            return $app['\Skidu\LaraWorker\Commands\CreateCommand'];
        });
        $this->commands('command.worker.create');
    }

    protected function registerCmdStart()
    {
        $this->app->singleton('command.worker.start', function($app){
            return $app['\Skidu\LaraWorker\Commands\StartCommand'];
        });
        $this->commands('command.worker.start');
    }

    protected function registerCmdRestart()
    {
        $this->app->singleton('command.worker.restart', function($app){
            return $app['\Skidu\LaraWorker\Commands\RestartCommand'];
        });
        $this->commands('command.worker.restart');
    }

    protected function registerCmdStop()
    {
        $this->app->singleton('command.worker.stop', function($app){
            return $app['\Skidu\LaraWorker\Commands\StopCommand'];
        });
        $this->commands('command.worker.stop');
    }

    protected function registerCmdReload()
    {
        $this->app->singleton('command.worker.reload', function($app){
            return $app['\Skidu\LaraWorker\Commands\ReloadCommand'];
        });
        $this->commands('command.worker.reload');
    }

    protected function registerCmdStatus()
    {
        $this->app->singleton('command.worker.status', function($app){
            return $app['\Skidu\LaraWorker\Commands\StatusCommand'];
        });
        $this->commands('command.worker.status');
    }
}
