<?php

declare (strict_types = 1);

namespace rztask\facade;


use think\Facade;
/**
 * @see \rztask\Task
 * @package think\facade
 * @method static mixed task_now(string $service_name,string $task_name,string $create_by,array $param) 立即执行的任务
 * @method static mixed task_later(int $later,string $service_name,string $task_name,string $create_by,array $param) 延时执行的任务
 */

class Task extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return 'rztask\Task';
    }
}
