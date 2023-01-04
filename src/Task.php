<?php

namespace rztask;

use rztask\job\CommonJob;
use think\facade\Db;
use think\facade\Queue;

class Task
{

    public function add_task($task_name,$create_by){
        $table = app()->config->get('task.table');
        $insert['task_name'] = $task_name;
        $insert['status'] = 1;
        $insert['create_by'] = $create_by;
        $insert['create_time'] = $insert['update_time'] = date("Y-m-d H:i:s");
        $task_id = Db::name($table)->insertGetId($insert);
        return $task_id;
    }
    public function task_now($service_name,$task_name,$create_by,$param){
        $namespace = $this->get_namespace()."\\".$service_name;
        $task_id = $this->add_task($task_name,$create_by);
        Queue::push(CommonJob::class, ['namespace'=>$namespace,'task_id'=>$task_id,'param'=>$param], $queue = app()->config->get('task.queue_name'));
        return $task_id;
    }

    public function task_later($later,$service_name,$task_name,$create_by,$param){
        $namespace = $this->get_namespace()."\\".$service_name;
        $task_id = $this->add_task($task_name,$create_by);
        Queue::later($later,CommonJob::class, ['namespace'=>$namespace,'task_id'=>$task_id,'param'=>$param], $queue = app()->config->get('task.queue_name'));
        return $task_id;
    }

    public function get_namespace(){
        $namespace = app()->config->get('task.service_path');
        return strtr($namespace,"/","\\");
    }
}