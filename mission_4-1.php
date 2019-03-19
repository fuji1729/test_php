<!DOCTYPE html>
<html lang="ja">
	<head>
		<title>ミッション4-1</title>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<meta charset="utf-8">
		<link rel="stylesheet" href="mission_4-1.css" "type=text/css">
	</head>
<body>

<h3>入力・削除・編集フォーム</h3>
<!-通常フォーム作成->
<form method="post" action="">
<p>
名前<br><input type="text" name="name" placeholder="名前"><br>
コメント<br>
<input type="text" name="comment" placeholder="コメント"><br>
パスワード<br>
<input type="password" name="pass" placeholder="パスワードを設定">
<input type="submit" value="投稿">
</p>
</form>
<br>

<!-削除フォーム作成->
<form method="post" action="mission_4-1sh.php">
<p>削除<br>
<input type="text" name="delete" placeholder="半角数字で入力">
<input type="submit" value="削除"></p>
</form>

<!-編集フォーム作成->
<form method="post" action="mission_4-1sh.php">

<p>編集<br>
<input type="text" name="edit" placeholder="半角数字で入力">
<input type="submit" value="編集"></p>
</form>


<?php


//データベース起動
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード名';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


//テーブル作成（存在しない時のみ）
$sql = "CREATE TABLE IF NOT EXISTS tbdata"
."("
."id INT,"
."name char(32),"
."comment TEXT,"
."date char(32),"
."pass char(32)"
.");";
$stmt = $pdo->query($sql);

//入力内容をPOST
$name = htmlspecialchars($_POST['name']);
$comment = htmlspecialchars($_POST['comment']);
$date = date("Y/m/d H:i:s");  
$pass = htmlspecialchars($_POST['pass']);
$edit_num = htmlspecialchars($_POST['edit_num']);
$edit_name = htmlspecialchars($_POST['edit_name']);
$edit_comment = htmlspecialchars($_POST['edit_comment']);


//通常入力
if (!empty($name) && !empty($comment) && !empty($pass)) {

	//id取得
	$sql = 'SELECT * FROM tbdata ORDER BY id DESC LIMIT 1';
	$stmt = $pdo -> query($sql);
	$result = $stmt->fetch();
	$id = $result['id'] + 1;
	
	//テーブルに登録
	$sql = $pdo -> prepare("INSERT INTO tbdata (id, name, comment, date, pass) VALUES (:id, :name, :comment, :date, :pass)");
	$sql -> bindParam(':id',$id, PDO::PARAM_STR);
	$sql -> bindParam(':name',$name, PDO::PARAM_STR);
	$sql -> bindParam(':comment',$comment, PDO::PARAM_STR);
	$sql -> bindParam(':date',$date, PDO::PARAM_STR);
	$sql -> bindParam(':pass',$pass, PDO::PARAM_STR);
	$sql -> execute();
}


//編集入力
if (!empty($edit_num) && !empty($edit_name) && !empty($edit_comment)) {
	
	//テーブルに登録
	$sql = 'update tbdata set name=:name,comment=:comment,date=:date where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt -> bindParam(':id',$edit_num, PDO::PARAM_INT);
	$stmt -> bindParam(':name',$edit_name, PDO::PARAM_STR);
	$stmt -> bindParam(':comment',$edit_comment, PDO::PARAM_STR);
	$stmt -> bindParam(':date',$date, PDO::PARAM_STR);
	$stmt -> execute();

}

?>



<br>
<div class="title">
<h1> 釣り人専用掲示板 </h1>
<p>※釣り人でなくても，もちろん書き込みいただけます</p>
</div>
<hr>

<?php
$sql = 'SELECT * FROM tbdata ORDER BY id';
$stmt = $pdo->query($sql);
$results = $stmt -> fetchAll();
foreach($results as $row){
	echo $row['id'];
	echo "&nbsp;".$row['name'].'<br><br>';
	echo $row['comment'].'<br><br>';
	echo "(".$row['date'].")".'<br>';
	echo '<hr>'; 
}
?>

</body>
</html>