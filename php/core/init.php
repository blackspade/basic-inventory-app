<?php
if(!isset($_SESSION)){ 
    session_start(); 
	session_regenerate_id();
} 

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db' => 'application'
     )
);
