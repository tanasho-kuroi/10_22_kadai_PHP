<?php

// ●●●●●●●●●●●●●●●　更新の処理内容　●●●●●●●●●●●●●●●●●●
//  joblist_edit.phpでjoblist_update.phpにidと更新内容を送る。updateの処理はjoblist_update.phpで行う
//  ↑joblist_input.phpとjoblist_create.php みたいな感じ

// 各値をpostで受け取る
$id = $_POST['id'];
$resistDate = $_POST['resistDate'];
$joblist = $_POST['joblist'];
$skill = $_POST['skill'];
$category = $_POST['category'];
$region = $_POST['region'];

session_start(); // セッションの開始
include('../functions.php'); // 関数ファイル読み込み
check_session_id(); // idチェック関数の実行

$pdo = connect_to_db(); //関数の出力を$pdoに代入

// データ登録SQL作成
// data登録SQL作成
$sql = "UPDATE joblist_table SET resistDate=:resistDate,
joblist=:joblist, skill=:skill, region=:region, category=:category,
updated_at=sysdate() WHERE id=:id";
// ここでもWHEREで指定！重要！！id指定がないと全部更新されちゃう！
// joblist_tableをUPDATE処理、それぞれの変数を割り当て、最後にWHEREでid指定。


// SQL準備&実行
$stmt=$pdo->prepare($sql);

$stmt->bindValue(':resistDate', $resistDate, PDO::PARAM_STR);
$stmt->bindValue(':joblist', $joblist, PDO::PARAM_STR);
$stmt->bindValue(':skill', $skill, PDO::PARAM_STR);
$stmt->bindValue(':category', $category, PDO::PARAM_STR);
$stmt->bindValue(':region', $region, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_STR);
$status = $stmt->execute();//$stmtを実行した結果を$statusに保存
//$stmtを１行ずつvar_dump  で確認したが、$stmtが変わっているわけではない(= (代入)ではないから？)

// var_dump($stmt);
// exit();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg"=>"{$error[2]}"]);
    exit();
} else {
// 正常にSQLが実行された場合は入力ページファイルに移動する
    // header("Location:joblist_input.php");
// 正常にSQLが実行された場合は一覧ページファイルに移動し、処理を実行する
    header("Location:../joblist/joblist_read.php");

    exit();
}
