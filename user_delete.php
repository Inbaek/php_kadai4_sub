<?php
//1.対象のIDを取得
$id = $_GET["id"];

//2.DB接続します
require_once('funcs2.php');
$pdo = db_conn2();

//3.削除SQLを作成
$stmt = $pdo->prepare("DELETE FROM gs_user_table WHERE id=:id"); //:はSQL Injection対策
$stmt->bindValue(':id',$id,PDO::PARAM_INT);

//実行
$status = $stmt->execute();

//４．データ登録処理後
if ($status == false) {
    sql_error($stmt);
} else {
    redirect('user_list.php');
}





