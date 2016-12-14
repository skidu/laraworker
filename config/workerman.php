<?php

return array(
    'run_conf' => storage_path('run') .DIRECTORY_SEPARATOR. 'workerman.conf',
    'log_file' => storage_path('logs'),    // default: storage/logs/<appname>.log
    'pid_file' => storage_path('run'),     // default: storage/run/hostname.pid
    'app_path' => app_path('Workerman'),   // default: app/Workerman/
    'apps' => array(
        // appname => options
        'timer' => array(),
    
    )
);
