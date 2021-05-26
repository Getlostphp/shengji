<?php


namespace app\admin\controller\device;


use think\queue\Job;

class Queue
{


    public function fire(Job $job,$info)
    {

        print_r('队列'.date('Y-m-d H:i:s')."\n");

        $job->delete();
    }
}
