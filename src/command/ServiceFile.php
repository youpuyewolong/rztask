<?php

namespace rztask\command;

use think\console\Command;
use think\console\input\Argument;
use think\helper\Str;

class ServiceFile extends Command
{

    protected function configure()
    {
        $this->setName('rztask:create')
            ->addArgument('name', Argument::REQUIRED, "service name")
            ->setDescription('Create Task ServiceFile File');
    }

    public function handle()
    {
        $name = trim($this->input->getArgument('name'));
        $name = Str::studly($name);
        $file_name = $name.".php";

        $namespace = $this->app->config->get('task.service_path');
        $namespace = strtr($namespace,"/","\\");
        // Load the alternative template if it is defined.
        $contents = file_get_contents(__DIR__ . '/stubs/taskservice.stub');

        // inject the class names appropriate to this migration
        $contents = strtr($contents, [
            'ServiceName' => $name,
            'NameSpace' => $namespace
        ]);
        $dir_path = $this->app->getRootPath() .$namespace;
        $file_path = $this->app->getRootPath() .$namespace . "\\" .$file_name;
        if (!is_dir($dir_path)){
            mkdir($dir_path, 0755, true);
        }
        $res = file_put_contents($file_path, $contents);

        $this->output->info($file_path.' created successfully!');
    }
}
