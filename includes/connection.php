<?php
include_once(dirname(dirname(__FILE__)) . '/config.php');


$db = connect_to_database();

function connect_to_database($host = UFL_SEARCH_DB_HOST, $username = UFL_SEARCH_DB_USERNAME, $password = UFL_SEARCH_DB_PASSWORD, $database = UFL_SEARCH_DB_NAME) {
    $db = mysql_connect($host, $username, $password);
    if (! $db) {
        trigger_error('Could not connect: ' . mysql_error(), E_USER_ERROR);
    }

    $result = mysql_select_db($database, $db);
    if (! $result) {
        trigger_error('Could not use database: ' . mysql_error(), E_USER_ERROR);
    }

    return $db;
}

function query_database($sql, $params = array()) {
    global $db;

    if (count($params) > 0) {
        $params = array_map('stripslashes', $params);
        $params = array_map('mysql_escape_string', $params);
	$sql = vsprintf($sql, $params);
    }

    $result = mysql_query($sql, $db);
    if (! $result) {
        trigger_error('Invalid query: ' . mysql_error(), E_USER_ERROR);
    }

    return $result;
}

function disconnect_from_database() {
    global $db;

    mysql_close($db);
}

register_shutdown_function('disconnect_from_database');
?>
