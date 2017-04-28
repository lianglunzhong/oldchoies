<?php   
require_once('../modules/kernel/classes/elastic/vendor/autoload.php');

function get_client()
{
    $host_params = array(
        'hosts' => array('192.168.186.157:9200'),
    );
    $client = new Elasticsearch\Client($host_params);
    return $client;
}

function get_conn(){  
    $host = 'localhost';  
    $dbname = 'clothes';  
    $user = 'root';  
    $passwd = '';  
  
    $conn = @mysql_connect($host, $user, $passwd) or die ("连接失败");
    mysql_select_db($dbname, $conn);
    return $conn;
}  
  
function create_index(){  
    $client = get_client();
    //Elastic search php client  
    $sql = "SELECT * FROM catalogs";  
    $conn = get_conn();
    $result = mysql_query($sql);
    $datas = array();
    while($row=mysql_fetch_array($result)){
        $datas[]=$row;
    }
    //delete index which already created  
    $params = array();  
    $params['index'] = 'catalog_index_basic';
    $client->indices()->delete($params);
      
    //create index on log_date,src_ip,dest_ip  
    $dataCount = count($datas);
    foreach($datas as $data)
    {
        if(empty($datas))
            continue;
        $params = array();  
        $params['body'] = array(
            'id' => $data['id'],
            'name' => $data['name'],  
            'title' => iconv('gbk', 'utf-8', $data['meta_title']),  
        );  
        $params['index'] = 'catalog_index_basic';  
        $params['type'] = 'catalog_type';  
        $params['test'] = 1111;
        // print_r($params);exit;
          
        //Document will be indexed to log_index/log_type/autogenerate_id          
        $response = @$client->index($params);
        print_r($response);
    }
}

function update()
{
    $client = get_client();
    /*
    [23] => Array
    (
        [_index] => catalog_index_basic
        [_type] => catalog_type
        [_id] => AVKrPiNu0Rn8on0QF1ms
        [_score] => 0.88193387
        [_source] => Array
            (
            [id] => 534
            [name] => Shirt Dress1
            [title] => Shirt Dress | Shop Shirt Dresses for Women | CHOiES
            )

    )
    */
    $params = array(
        'index' => 'catalog_index_basic',
        'type' => 'catalog_type',
        'id' => 'AVKrPiNu0Rn8on0QF1ms',
        'body' => array(
            'doc' => array(
                'name' => 'Shirt Dress1'
            )
        )
    );

    $rtn = $client->update($params);  
    print_r($rtn);
}

function delete()
{
    $client = get_client();
    // $params = array(
    //     'index' => 'product_basic_',
    //     'type' => 'product_',
    //     // 'id' => 'AVKrPiNu0Rn8on0QF1ms',
    // );

    // // Delete doc at /my_index/my_type/my_id
    // $rtn = $client->delete($params);
    // print_r($rtn);
    $indexs = array(
        'product_basic_', 'product_basic_es', 'product_basic_de', 'product_basic_fr'
    );
    foreach($indexs as $index)
    {
        $delete_params = array(
            'index' => $index,
        );
        try
        {
            $res = $client->indices()->delete($delete_params);
        }
        catch (Exception $e)
        {
            $res['error'] = $e;
        }
        print_r($res);
        echo "<br>\n";
    }
    exit;
}
  
function search(){  
    $client = get_client();
    //Elastic search php client  
    // $params = array();  
    // $params['index'] = 'catalog_index_basic';  
    // $params['type'] = 'catalog_type';
    // $params['size'] = 50;
    // $params['body']['query']['match']['name'] = 'dress';

    /* AND */
    // $params = array(
    //     'index' => 'catalog_index_basic',
    //     'type' => 'catalog_type',
    //     'body' => array(
    //         'query' => array(
    //             'bool' => array(
    //                 'must' => array(
    //                     array( 'match' => array( 'name' => 'shoes' ) ),
    //                     array( 'match' => array( 'title' => 'shoes' ) ),
    //                 )
    //             )
    //         )
    //     )
    // );

    /* Pagination */
    // $params = array(
    //     'index' => 'catalog_index_basic',
    //     'type' => 'catalog_type',
    //     "size" => 10,
    //     "from" => 10,
    //     'body' => array(
    //         'query' => array(
    //             'filtered' => array(
    //                 'filter' => array(
    //                     'term' => array( 'name' => 'shoes' )
    //                 )
    //             )
    //         )
    //     )
    // );

    /* ONLY GET COUNT */
    // $params = array(
    //     "search_type" => "scan",    // use search_type=scan
    //     "scroll" => "30s",          // how long between scroll requests. should be small!
    //     "size" => 50,               // how many results *per shard* you want back
    //     "index" => "catalog_index_basic",
    //     "body" => array(
    //         "query" => array(
    //             "match_all" => array(
    //             )
    //         )
    //     )
    // );

    /* OR */
    // $params = array(
    //     'index' => 'product_basic_',
    //     'type' => 'product_',
    //     "size" => 50,
    //     "from" => 0,
    //     'body' => array(
    //         "query" => array(
    //             "filtered" => array(
    //                 "query" => array(
    //                     "multi_match" => array(
    //                         "query" => "92 108 203 204 205 206 207 209 210 211 212 215 216 333 454 456 504 505 507 511 526 652 724 725 515 516 517 518 519 520 521 512 513 514 522 523",
    //                         "fields" => array( "default_catalog" )
    //                     ),
                        
    //                     // 'filter' => [
    //                     //     'term' => [ 'visibility' => '1'],
    //                     // ],
    //                 ),
    //                 "filter" => [
    //                     "bool" => [
    //                         "must" => [
    //                             [ "term" => ["visibility" => 1]],
    //                             [ "term" => ["status" => 1]],
    //                             [ "range" => ["price" => ["gte" => 100]] ],
    //                         ]
    //                         // "should" => [
    //                         //     [ "match" => ["attributes" => "sizeXS"]],
    //                         // ]
    //                    ]
    //                 ],
    //             ),
    //         ),
    //         'sort' => Array(
    //             'position' => Array(
    //                 'order' => 'desc'
    //             ),
    //         )
    //     )
    // );

    $params = array(
        'index' => 'product_basic_',
        'type' => 'product_',
        "size" => 50,
        "from" => 0,
        'body' => array(
            "query" => array(
                "filtered" => array(
                    "query" => array(
                        "multi_match" => array(
                            "query" => "92 108 203 204 205 206 207 209 210 211 212 215 216 333 454 456 504 505 507 511 526 652 724 725 515 516 517 518 519 520 521 512 513 514 522 523",
                            "fields" => array( "default_catalog" )
                        ),
                        
                        // 'filter' => [
                        //     'term' => [ 'visibility' => '1'],
                        // ],
                    ),
                    "filter" => [
                        "bool" => [
                            "must" => [
                                [ "term" => ["visibility" => 1]],
                                [ "term" => ["status" => 1]],
                                [ "term" => ["has_promotion" => 1]],
                                // [ "range" => ["price" => ["gte" => 1, "lte" => 2, "ttt" => 0]] ],
                            ]
                            // "should" => [
                            //     [ "match" => ["attributes" => "sizeXS"]],
                            // ]
                       ]
                    ],
                ),
            )
        )
    );

    // print_r($params);exit;

    $rtn = $client->search($params);  
    print_r($rtn);  
}  

set_time_limit(0);
$type = isset($_GET['type']) ? $_GET['type'] : 0;
if($type == 0)
{
    search();
}
elseif($type == 1)
{
    create_index();
}
elseif($type == 2)
{
    update();
}
elseif($type == 3)
{
    delete();
}
// create_index();
// search();
// update();
// delete();
?>  