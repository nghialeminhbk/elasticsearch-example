<?php 
    $page = $_GET['page'] ?? '';

    $menuitems = [
        'manageindex' => 'Quản lý Index',
        'document' => "Document",
        'search' => 'Tìm kiếm'
    ];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <title>Thực hành elasticsearch</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
   <a class="navbar-brand" href="#">Brand-Logo</a>
   <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#my-nav-bar" aria-controls="my-nav-bar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
   </button>
   <div class="navbar-collapse collapse" id="my-nav-bar" style="">
   <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link" href="./">Trang chủ</a></li>
    <?php
        foreach($menuitems as $url => $label){
            $class = '';
            if($url == $page){
                $class = 'active';
            }
            echo "
                <li class='nav-item $class'>
                    <a class='nav-link' href='./?page=$url'> $label </a>
                </li>
                ";
        }
    ?>
    </ul>
   </div>
</nav>    
    <?php
        if($page != ''){
            include $page.".php";
        }else{
            echo "<p class='text-danger display-4'>Thực hành elasticsearch</p>";
        }
    ?>
</body>
</html>