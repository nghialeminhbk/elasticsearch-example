<?php
    require_once "./vendor/autoload.php";
    use Elasticsearch\ClientBuilder;
    $hosts = [
        [   
            'host' => 'localhost',
            'port' => '9200',
            'scheme' => 'http'
        ]
    ];

    $client = ClientBuilder::create()->setHosts($hosts)->build();

    $exists = $client->indices()->exists(['index'=>'artical']); // kiem tra index co ton tai hay chua, tra ve bool

    if(!$exists){
        throw new Exception("Index - artical đang không tồn tại");
    }

    $search = $_POST['search']??'';

    if($search != ''){
        $params = [
            'index'=>'artical',
            'type'=> 'artical_type',
            'body' => [
                'query' => [
                    'multi_match' => [
                        'query' => $search,
                        'fields'=> ['title', 'content', 'keyword'],
                        'fuzziness'=> 'auto'
                    ]
                    ],
                    'highlight' =>[
                        'pre_tags' => ["<em><strong class='text-warning'>"],
                        'post_tags' => ["</strong></em>"],
                        'fields' => [
                            'title' => new stdClass(),
                            'content' => new stdClass()
                        ]
                    ]
            ]
        ];
        $rs = $client->search($params);
        $items = null;

        $total = $rs['hits']['total']['value'];
        if($total > 0){
            $items = $rs['hits']['hits'];
        }
        // var_dump($total, $items);
    }
?>

<div class="card m-4">
    <div class="card-header text-danger display-4">Tìm kiếm elasticsearch</div>
    <div class="card-body">
        <form action="#" class="form" method="POST">
            <div class="form-group mt-3">
                <label for="">Search content</label>
                <input type="text" name="search" class="form-control">
            </div>
            <div class="form-group mt-3">
                <input class="btn btn-info" type="submit" name="submit" id="" value="Search" >   
            </div>

            <?php
            if(isset($items)){
                foreach($items as $item){
                    $title = $item['_source']['title'];
                    $content = $item['_source']['content'];
                    $keyword = implode(',',$item['_source']['keyword']);

                    if(isset($item['highlight']['title'])){
                        $title = implode(" ",$item['highlight']['title']);
                    }
                    if(isset($item['highlight']['content'])){
                        $content = implode(" ",$item['highlight']['content']);
                    }
                    echo "
                    <p class='mt-3'>
                        <strong>$title</strong><br>
                        $content
                    </p>
                    <hr>
                    ";
                }
            }
            ?>
        </form>
    </div>
</div>