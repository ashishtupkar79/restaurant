<?php
$val='N9O+w2wKAcrgUOjsxMybNFuUc9nEGgQ9suP7J42ZUwM=';
$hashkey="resTaurant@zaikart.com";
echo $val_dec =rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($hashkey), base64_decode($val), MCRYPT_MODE_CBC, md5(md5($hashkey))), "\0");
?>