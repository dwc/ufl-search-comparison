<?php
$url_format = 'http://%s.ns.ufl.edu/search?q=%s&btnG=Google+Search&access=p&entqr=3&output=xml_no_dtd&sort=date%%3AD%%3AL%%3Ad1&entsp=0&client=default_frontend&ud=1&oe=UTF-8&ie=UTF-8&proxystylesheet=default_frontend&site=default_collection';

$boxes = array('googlea', 'googleb');

$index = rand(0, count($boxes) - 1);
$left = $boxes[$index];
$right = $boxes[1 - $index];
?>
