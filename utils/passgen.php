<?php

$string = "Inventory123#";


$options = ['cost' => 12];
	
$pass = password_hash($string, PASSWORD_BCRYPT,$options);


echo $pass;



?>