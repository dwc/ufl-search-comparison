<?php
$db = connect_to_database();

function connect_to_database($host = '', $username = '', $password = '', $database = '') {
    $db = mysql_connect($host, $username, $password);
    if (! $db) {
        die('Could not connect: ' . mysql_error());
    }

    $result = mysql_select_db($database, $db);
    if (! $result) {
        die('Could not use database: ' . mysql_error());
    }

    return $db;
}

function query_database($sql, $params = array()) {
    global $db;

    if (count($params) > 0) {
        $params = array_map('mysql_escape_string', $params);
	$sql = vsprintf($sql, $params);
    }

    $result = mysql_query($sql, $db);
    if (! $result) {
        die('Invalid query: ' . mysql_error());
    }

    return $result;
}

function disconnect_from_database() {
    global $db;

    mysql_close($db);
}

register_shutdown_function('disconnect_from_database');
?>
