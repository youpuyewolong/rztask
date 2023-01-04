<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2015 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: yunwuxin <448901948@qq.com>
// +----------------------------------------------------------------------

namespace rztask\command;

use think\console\Command;
use think\console\Input;
use think\console\input\Argument;
use think\console\input\Option;
use think\console\Output;
use think\queue\Listener;

class Listen extends Command
{
    /** @var  Listener */
    protected $listener;

    public function __construct(Listener $listener)
    {
        parent::__construct();
        $this->listener = $listener;
        $this->listener->setOutputHandler(function ($type, $line) {
            $this->output->write($line);
        });
    }

    protected function configure()
    {
        $this->setName('rztask:listen')
            ->addOption('delay', null, Option::VALUE_OPTIONAL, 'Amount of time to delay failed jobs', 0)
            ->addOption('memory', null, Option::VALUE_OPTIONAL, 'The memory limit in megabytes', 128)
            ->addOption('sleep', null, Option::VALUE_OPTIONAL, 'Seconds to wait before checking queue for jobs', 3)
            ->addOption('tries', null, Option::VALUE_OPTIONAL, 'Number of times to attempt a job before logging it failed', 0)
            ->setDescription('Listen to a given queue');
    }

    public function execute(Input $input, Output $output)
    {
        $connection = $this->app->config->get('queue.default');

        $queue   = $this->app->config->get("task.queue_name");
        $delay   = $input->getOption('delay');
        $memory  = $input->getOption('memory');
        $timeout = 0;
        $sleep   = $input->getOption('sleep');
        $tries   = $input->getOption('tries');

        $this->listener->listen($connection, $queue, $delay, $sleep, $tries, $memory, $timeout);
    }
}
