<?php
namespace app\admin\controller\device;


use app\common\controller\Backend;

class Sensor  extends Backend
{

    public function _initialize()
    {
        parent::_initialize();
        $this->model = model('app\common\model\Category');

    }
    public function index()
    {

        $job = 'app\admin\controller\device\Queue@fire';

        $params = ['a'=>123,'b'=>321];

       $res =  \think\Queue::push($job,$params,null);

       if($res){
           echo '加入队列成功';
       }

    }
}