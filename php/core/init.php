<?php
if(!isset($_SESSION)){ 
    session_start(); 
} 

$GLOBALS['config'] = array(
    'mysql' => array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => '',
        'db' => 'application'
     )
);
