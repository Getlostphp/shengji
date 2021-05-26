<?php


namespace app\admin\controller\device;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use think\Db;


class Es
{
    public function index()
    {


        $client = ClientBuilder::create()->setHosts(['127.0.0.1'])->build();

        $params = [
            'index' => 'test', #index的名字不能是大写和下划线开头
            'body' => [
                'settings' => [
                    'number_of_shards' => 2,
                    'number_of_replicas' => 0
                ]
            ]
        ];
        $client->indices()->create($params);


        $params = [
            'index' => 'test',
            'type' => 'mytype',
            'include_type_name'=>true,
            'body' => [
                'mytype' => [
                    '_source' => [
                        'enabled' => true,
                    ],
                    'properties' => [
                        'id' => [
                            'type' => 'integer'
                        ],
                        'deptno' => [
                            'type' => 'integer',
                        ],
                        'dname' => [
                            'type' => 'text',
                        ],
                        'loc' => [
                            'type' => 'text',
                        ],
                    ]
                ]
            ]
        ];
        $client->indices()->putMapping($params);





        echo '成功';
    }


    public function add()
    {

        set_time_limit(0);
        $msyql = Db::connect([
            // 数据库类型
            'type'        => 'mysql',
            // 数据库连接DSN配置
            'dsn'         => '',
            // 服务器地址
            'hostname'    => '127.0.0.1',
            // 数据库名
            'database'    => 'test',
            // 数据库用户名
            'username'    => 'root',
            // 数据库密码
            'password'    => 'root123',
            // 数据库连接端口
            'hostport'    => '3306',
            // 数据库连接参数
            'params'      => [],
            // 数据库编码默认采用utf8
            'charset'     => 'utf8',
            // 数据库表前缀
            'prefix'      => '',
        ]);
        $client = ClientBuilder::create()->setHosts(['127.0.0.1'])->build();

        $list = $msyql->name('dept')->where('id','BETWEEN',[41000,43000])->select();

        $n = 0;
        foreach ($list as $val){

            $params = [
                'index' => 'test',
                'type' => 'mytype',
                'body' => [
                    'deptno' => $val['deptno'],
                    'dname' => $val['dname'],
                    'loc' => $val['loc']
                ]
            ];

            $client->index($params);
            $n++;

        }
        echo '插入成功'.$n.'-last43000';



    }

    public function get()
    {
        $client = ClientBuilder::create()->setHosts(['127.0.0.1'])->build();

//        $where = [
//            'index' => 'test',
//            'type' => 'mytype',
//            'body' =>  [
//                'query' => [
//                    'bool' => [
//                        'filter' => [
//                            'term' => [ 'deptno' => '10001' ]
//                        ],
//                        'should' => [
//                            'match' => [ 'loc' => 'ymP' ]
//                        ]
//                    ]
//                ]
//            ]
//        ];
        $where = [
            'index' => 'test',
            'type' => 'mytype',
            'from'=>'0',
            'size'=>'100',
            'body' =>  [
                'query' => [
                    'bool'=>[
                        'must'=>[
                            'wildcard' => [
                                'loc' =>['value'=>'*RClx*']
                            ]
                        ]
                    ]

                ]
            ]
        ];

        $list = $client->search($where);

        halt($list);
    }


    public function del()
    {
        $client = ClientBuilder::create()->setHosts(['127.0.0.1'])->build();

        $params = [
            'index'=>'myindex'
        ];

        $res = $client->indices()->delete($params);

        halt($res);
    }
}