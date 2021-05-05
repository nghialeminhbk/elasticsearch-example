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

    /**
     * DOCUMENT
     * title
     * content
     * keyword
     */

    $id = $_POST['id']??null;
    $title = $_POST['title']??null;
    $content = $_POST['content']??null;
    $keyword = $_POST['keyword']??null;

    $msg = '';
    if($id!=null && $title!=null && $content!=null && $keyword!=null){
        //Update or create new document vao index: artical
        $params = [
            'index'=>'artical',
            'type' =>'artical_type',
            'id' => $id,
            'body' => [
                'title'=>$title,
                'content'=>$content,
                'keyword'=> explode(',', $keyword)
            ]
        ];

        var_dump($params);
        $client->index($params);

        $msg = "Update successfull for document id = $id";

        $id = $title = $content = $keyword = null;
    }



?>

    <div class="card m-4">
        <div class="card-header text-danger display-4">Tạo/ Cập nhật Document</div>
        <div class="card-body">
            <form action="#" class="" method="POST">
                <div class="form-group mt-3">
                    <label for="">ID Document</label>
                    <input type="text" name="id" class="form-control" value=<?=$id?>>
                </div>
                <div class="form-group mt-3">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control" value=<?=$title?> >
                </div>
                <div class="form-group mt-3">
                    <label for="">Content</label>
                    <textarea type="text" name="content" class="form-control" value=<?=$content?> ></textarea>
                </div>
                <div class="form-group mt-3">
                    <label for="">Keyword</label>
                    <input type="text" name="keyword" class="form-control" <?=$keyword?> >
                </div>
                <div class="form-group mt-3">
                    <input class="btn btn-info" type="submit" name="submit" id="" value="Update" >   
                </div>
            </form>

            <div class="alert alert-info mt-4">
                <?=$msg?>
            </div>
        </div>
    </div>