<?php

//SESSIONスタート
session_start();

//関数を呼び出す
require_once('funcs2.php');

//ログインチェック
loginCheck();
$user_name = $SESSION['name'];

if($_SESSION['kanri_flg'] =="1"){

echo '<table border="1">
      <caption align="top">ユーザー一覧</caption>
      <tr>
      <th>ユーザー名</th>
      <th>ユーザーID</th>
      <th>ユーザーPW</th>
      <th>管理ステータス</th>
      <th>入社・退社</th>
      </tr>';

//funcs.phpを呼び出す
require_once('funcs2.php');
//1.  DB接続します
try {
  //Password:MAMP='root',XAMPP=''
  $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost','root','root');
} catch (PDOException $e) {
  exit('DBConnectError:'.$e->getMessage());
}

//２．SQL文を用意(データ取得：SELECT)
$stmt = $pdo->prepare("SELECT*FROM gs_user_table ORDER BY id ASC");

//3. 実行
$status = $stmt->execute();

//4．データ表示
$view="";
if($status==false) {
    //execute（SQL実行時にエラーがある場合）
  $error = $stmt->errorInfo();
  exit("ErrorQuery:".$error[2]);

}else{
  //Selectデータの数だけ自動でループしてくれる
  //FETCH_ASSOC=http://php.net/manual/ja/pdostatement.fetch.php
  while( $result = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    echo "<tr>\n";
    echo "<td>{$result['name']}</td>\n";
    echo "<td>{$result['lid']}</td>\n";
    echo "<td>{$result['lpw']}</td>\n";
    echo "<td>{$result['kanri_flg']}</td>\n";
    echo "<td>{$result['life_flg']}</td>\n";
    echo '<td><a href="user_update_view.php?id='.$result["id"].'">';
    echo '[ 更新 ]';
    echo '</a></td>';
    echo '<td><a href="user_delete.php?id='.$result["id"].'">';
    echo '[ 削除 ]';
    echo '</a></td>';
    echo "</tr>\n";

  }

}

echo '</table>';

}else{
  echo "管理権限がありません";
};

?>


<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ユーザー表示</title>
<link rel="stylesheet" href="css/list.css?v=2">
<style>div{padding: 10px;font-size:16px;}</style>
</head>
<body id="main">

<header>
  <nav class="navbar navbar-default">
    <div class="container-fluid">
      <div class="navbar-header">
      <a class="navbar-brand" href="index.php">メニューへ</a>
      </div>
    </div>
  </nav>
</header>

<div>
    <div class="container jumbotron"><?= $view?></div>
    <a class="navbar-brand" href="user_toroku.php">ユーザー登録</a>
</div>

</body>
</html>
