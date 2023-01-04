<?php

namespace rztask\task;

use rztask\model\Task;
use think\facade\Db;

class BaseTask{


    public function do_task($task_id,$param){

        $table = app()->config->get('task.table');
        try {
            $res = $this->do_task_handle($param);
            $status = 3;
        }catch (\Exception $e){
            $res = '任务执行出错';
            $status = 4;
        }
        Db::name($table)->where('id','=',$task_id)->update(['status'=>$status,'result'=>$res]);
    }

    protected function do_task_handle($param){
        return '任务执行完成';
    }


}
