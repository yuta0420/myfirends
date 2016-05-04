<?php

  //1.DBの接続準備
  $dsn='mysql:dbname=myfriends;host=localhost:8080';//本来はIPアドレスを指定

  //接続するためのユーザー情報
  $user='root';
  $password='sp4p09y6';

  //DB接続オブジェクトを作成
  $dbh=new PDO($dsn,$user,$password);

  //接続したDBオブジェクトで文字コードutf8を使うように指定
  $dbh->query('SET NAMES utf8');


  //SQL文の作成
  // $sql = 'SELECT*FROM`areas`';
  $sql='SELECT `areas`.`area_id`,`areas`.`area_name`,COUNT(`friends`.`friend_id`) AS friends_cnt FROM `areas` LEFT OUTER JOIN`friends` ON `areas`.`area_id`=`friends`.`area_id` GROUP BY `areas`.`area_id`ORDER BY `areas`.`area_id`';

  //SQLの実行
  $stmt = $dbh->prepare($sql);
  $stmt->execute();

  //SQLの実行結果の取得

  $areas=array();

  while(1){
    //データを取得
    $rec=$stmt->fetch(PDO::FETCH_ASSOC);
    if($rec == false){
      break;
    }
    $areas[]=$rec;
  }

  //データベース切断
  $dbh=null;


?>



<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>myFriends</title>

    <!-- Bootstrap -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/form.css" rel="stylesheet">
    <link href="assets/css/timeline.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header page-scroll">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="index.php"><span class="strong-title"><i class="fa fa-facebook-square"></i> My friends</span></a>
          </div>
          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>

  <div class="container">
    <div class="row">
      <div class="col-md-4 content-margin-top">
      <legend>都道府県一覧</legend>
        <table class="table table-striped table-bordered table-hover table-condensed">
          <thead>
            <tr>
              <th><div class="text-center">id</div></th>
              <th><div class="text-center">県名</div></th>
              <th><div class="text-center">人数</div></th>
            </tr>
          </thead>
          <tbody>
            <!-- id, 県名を表示 -->

            <?php foreach($areas as $area){?>
            <tr>
              <td><div class="text-center"><?php echo $area['area_id']; ?></div></td>
              <td><div class="text-center"><a href="show.php?area_id=<?php echo $area['area_id'];?>"><?php echo $area['area_name']; ?></a></div></td>
              <td><div class="text-center"><?php echo $area['friends_cnt']?></div></td>
            </tr>
            <?php }?>
            
          </tbody>
        </table>
      </div>
    </div>
  </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
