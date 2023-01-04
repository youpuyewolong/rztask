<?php

namespace rztask;


use rztask\command\Listen;
use rztask\command\Table;
use rztask\command\ServiceFile;

class Service extends \think\Service
{
    public function register()
    {
        
    }

    public function boot()
    {
        $this->commands([
            Table::class,
            ServiceFile::class,
            Listen::class
        ]);
    }
}
