<?php
define('UFL_SEARCH_DB_HOST', 'localhost');
define('UFL_SEARCH_DB_USERNAME', 'search');
define('UFL_SEARCH_DB_PASSWORD', 's3cr3t');
define('UFL_SEARCH_DB_NAME', 'search');
define('UFL_SEARCH_MAX_QUERIES', 10);

$UFL_SEARCH_BOXES = array(
    'one' => 'http://google1.example.com/search?q=%s&btnG=Google+Search&access=p&entqr=3&output=xml_no_dtd&sort=date%%3AD%%3AL%%3Ad1&entsp=0&client=default_frontend&ud=1&oe=UTF-8&ie=UTF-8&proxystylesheet=default_frontend&site=default_collection',
    'two' => 'http://google2.example.com/search?q=%s&btnG=Google+Search&access=p&entqr=3&output=xml_no_dtd&sort=date%%3AD%%3AL%%3Ad1&entsp=0&client=default_frontend&ud=1&oe=UTF-8&ie=UTF-8&proxystylesheet=default_frontend&site=default_collection',
);
?>
