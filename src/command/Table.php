<?php

namespace rztask\command;

use think\console\Command;
use think\helper\Str;
use think\migration\Creator;

class Table extends Command
{
    protected function configure()
    {
        $this->setName('rztask:table')
            ->setDescription('Create a migration for the task database table');
    }

    public function handle()
    {
        if (!$this->app->has('migration.creator')) {
            $this->output->error('Install think-migration first please');
            return;
        }

        $table_pre = $this->app->config->get('database.connections.mysql.prefix');
        $table = $table_pre.$this->app->config->get('task.table');

        $className = Str::studly("create_{$table}_table");

        /** @var Creator $creator */
        $creator = $this->app->get('migration.creator');

        $path = $creator->create($className);

        // Load the alternative template if it is defined.
        $contents = file_get_contents(__DIR__ . '/stubs/task.stub');

        // inject the class names appropriate to this migration
        $contents = strtr($contents, [
            'CreateTaskTable' => $className,
            '{{table}}'       => $table,
        ]);

        file_put_contents($path, $contents);

        $this->output->info('Migration created successfully!');
    }
}
