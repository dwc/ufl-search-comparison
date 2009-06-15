<?php
$boxes = array('googlea', 'googleb');

$index = rand(0, count($boxes) - 1);
$left = $boxes[$index];
$right = $boxes[1 - $index];
?>
