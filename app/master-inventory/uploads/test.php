<?php

$arr = [];

$json = '{"images":["1572380223.JPG","1572380224.JPG"]}';


//var_dump(json_decode($json));

$i = array("1572380223.JPG","1572380224.JPG");

$arr["images"] = $i;

echo json_encode($arr);

/*
{"images":["1572451163.JPG"]}
{"images":["1572380223.JPG"]}
*/