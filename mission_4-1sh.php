<?php
//データベース起動
$dsn = 'データベース名';
$user = 'ユーザー名';
$password = 'パスワード名';
$pdo = new PDO($dsn, $user, $password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));


$edit_number = htmlspecialchars($_POST['edit']);//editしたい番号がmission_2-5.phpから送られてくる
$delete_number = htmlspecialchars($_POST['delete']);//deleteしたい番号がmission_2-5.phpから送られてくる
$input_pass = $_POST['pass'];//入力されたパスワード


//削除のパスワード入力フォーム
if (is_numeric($delete_number) && empty($input_pass)){
?>
	<!-パスワード入力フォーム作成->
	<form method="post" action="">
	<p>削除する番号 <?php echo $delete_number; ?> <br>
	<input type="hidden" name="delete" value="<?php echo $delete_number; ?>"><br>
	<p>パスワードを入力してください<br>
	<input type="password" name="pass"><br>
	<input type="submit" value="削除"></p>
	</form>
<?php
}


//パスワード入力後の削除処理
if (is_numeric($delete_number) && !empty($input_pass)){

    $sql = 'SELECT * FROM tbdata WHERE id='.$delete_number;
	$stmt = $pdo -> query($sql);
	$result = $stmt->fetch();
	$delete_line_pass = $result['pass'];
    
	if ($delete_line_pass == $input_pass){
		
		$sql = 'delete from tbdata where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':id', $delete_number, PDO::PARAM_INT);
		$stmt->execute();
	    echo "削除に成功しました（3秒後に掲示板に戻ります） <br>";
		$time = 1;
?>
	<a href="/mission_4-1.php">掲示板に戻る</a>
<?php

	}elseif($delete_line_pass != $input_pass){
		$time = 1;
		echo "パスワードが違います（3秒後に掲示板に戻ります） <br>";
?>
        <a href="/mission_4-1.php">掲示板に戻る</a>
<?php
	}
}




//編集用パスワード入力
if (is_numeric($edit_number) && empty($input_pass)){
?>
	<!-パスワード入力フォーム作成->
	<form method="post" action="">
	<p>編集する番号 <?php echo $edit_number; ?> <br>
	<input type="hidden" name="edit" value="<?php echo $edit_number; ?>"><br>
	<p>パスワードを入力してください<br>
	<input type="password" name="pass"><br>
	<input type="submit" value="編集"></p>
	</form>
<?php
}



if (is_numeric($edit_number) && !empty($input_pass)){

    $sql = 'SELECT * FROM tbdata WHERE id='.$edit_number;
	$stmt = $pdo -> query($sql);
	$result = $stmt->fetch();
	$edit_line_name = $result['name'];
	$edit_line_comment = $result['comment'];
	$edit_line_pass = $result['pass'];
    
    
    // 編集用フォーム作成
	if ($edit_line_pass == $input_pass){
?>
		
			<form method="post" action="mission_4-1.php">
			<p>編集する番号 <?php echo $edit_number; ?> <br>
			<input type="hidden" name="edit_num" value="<?php echo $edit_number; ?>"><br>
			
			<p>編集用フォームです<br>
			名前<br>
			<input type="text" name="edit_name" value="<?php echo $edit_line_name; ?>"><br>
			コメント<br>
			<input type="text" name="edit_comment" value="<?php echo $edit_line_comment; ?>">
			<input type="submit" value="この内容に変更"></p>
			</form>

	<a href="/mission_4-1.php">掲示板に戻る</a>
<?php

	}elseif($edit_line_pass != $input_pass){
		$time = 1;
		echo "パスワードが違います（3秒後に掲示板に戻ります） <br>";
?>
        <a href="/mission_4-1.php">掲示板に戻る</a>
<?php
	}
}
?>





<!DOCTYPE html>
<html lang="ja">
	<head>
		<title>ミッション4-1sh</title>
		<meta http-equiv="Pragma" content="no-cache">
		<meta http-equiv="cache-control" content="no-cache">
		<meta http-equiv="expires" content="0">
		<meta charset="utf-8">
		<link rel="stylesheet" href="mission_4-1.css" "type=text/css">
<?php
if($time == 1){
?>
		<meta http-equiv="Refresh" content="3, /mission_4-1.php">
<?php
}
?>
	</head>
<body>











</body>
</html>
