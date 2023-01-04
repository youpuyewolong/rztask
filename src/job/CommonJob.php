<?php

namespace rztask\job;

use think\facade\Db;
use think\queue\Job;

class CommonJob{


    public function fire(Job $job, $param){
        echo "已进入队列jobId:".$job->getJobId().PHP_EOL;
        $table = app()->config->get('task.table');
        $task = Db::name($table)->where('id','=',$param['task_id'])->find();
        if($task['status'] == 2){
            $job->delete();
        }else{
            try {
                Db::name($table)->where('id','=',$param['task_id'])->update(['status'=>2]);
                app($param['namespace'])->do_task($param['task_id'],$param['param']);
            }catch (\Exception $e){
                dump($e);
            }
            $job->delete();
        }
    }

    public function failed($data){

    // ...任务达到最大重试次数后，失败了
    }

}
