任务插件使用说明

安装
composer require rvzhi/task

config目录下会新增配置文件task.php（可任意修改）

migrate建表
php think rztask:table
php think migrate:run

启动任务监听
php think rztask:listen

创建任务处理类
php think rztask:create xxxxx
xxxxx类似于export_people 会把下划线自动转为驼峰

给任务处理类添加任务
Task::task_now('ExportPeople','首次任务测试','1',['a'=>11111,'b'=>2222]);
传参分别是：处理任务的类名，任务名称，创建人，任务参数
Task::task_later(10,'ExportPeople','延时任务测试','1',['a'=>11111,'b'=>2222]);
传参分别是：延时执行秒数，处理任务的类名，任务名称，创建人，任务参数


在配置文件service_path下生成的类中编写任务执行逻辑

该类中param即创建任务时传的param
do_task_handle方法 return的值 会被填在任务表的result字段
