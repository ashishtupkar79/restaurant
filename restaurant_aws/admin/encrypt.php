<?php
	 include ('../db_connect.php');
	$password='N9O+w2wKAcrgUOjsxMybNFuUc9nEGgQ9suP7J42ZUwM=';
	$connection = new createConnection(); //i created a new object
	echo $password_enc = $connection->dec_data($password);
?>