<?php

namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

class Test extends Model
{

    use SoftDelete;

    protected $connection = [
        // 数据库类型
        'type'        => 'Mongodb',
        // 服务器地址
        'hostname'    => '127.0.0.1',
        // 数据库名
        'database'    => 'mydb',

        'pk_convert_id' => true,
    ];


    





}
