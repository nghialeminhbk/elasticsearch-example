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

    $indices = $client->cat()->indices();

    // tao/ xoa index: artical

    $action = $_GET['action']??'';
    if($action == 'create'){
        // tao index artical;
        if(!$exists){
            $client->indices()->create(['index'=>'artical']);
        }
    }else if($action == 'delete'){
        // xoa index artical;
        if($exists){
            $client->indices()->delete(['index'=>'artical']);
        }
    }

    $msg = $exists ? "Index - Artical đang tồn tại" : "Index - Artical đang không tồn tại";
    
?>
    <div class="card m-4">
        <div class="card-header text-danger display-4">Quản lý Index</div>
        <div class="card-body">
            <?php 
                if(!$exists){
                    echo "<a class='btn btn-success' href='http://localhost:8080/elasticsearch-example/?page=manageindex&action=create'> Tạo index: Artical </a>";
                }else{
                    echo "<a class='btn btn-danger' href='http://localhost:8080/elasticsearch-example/?page=manageindex&action=delete'> Xóa index: Artical </a>";
                }
            ?>
            <div class="alert alert-primary mt-3">
                <?=$msg?>
            </div>
        </div>
    </div>

