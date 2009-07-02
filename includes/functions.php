<?php
include_once(dirname(dirname(__FILE__)) . '/config.php');
include_once(dirname(__FILE__) . '/connection.php');


function load_queries($filename = 'queries.txt', $num_queries = UFL_SEARCH_MAX_QUERIES) {
    session_start();

    // Select a random set of queries for the survey
    $queries = rtrim(file_get_contents($filename));
    $queries = split("\n", $queries);
    shuffle($queries);

    $_SESSION['queries'] = array_slice($queries, 0, $num_queries);
    $_SESSION['index'] = 0;
}

function current_query() {
    session_start();

    return $_SESSION['queries'][$_SESSION['index']];
}

function next_query() {
    session_start();

    return $_SESSION['queries'][++$_SESSION['index']];
}

function survey_started() {
    session_start();

    return (isset($_SESSION['queries']) and isset($_SESSION['index']));
}

function survey_finished() {
    session_start();

    return ($_SESSION['index'] == count($_SESSION['queries']));
}

function survey_progress($separator = ' of ') {
    session_start();

    return $_SESSION['index'] + 1 . $separator . count($_SESSION['queries']);
}

function display_ui($query) {
    global $UFL_SEARCH_BOXES;

    $boxes = array_keys($UFL_SEARCH_BOXES);

    $index = rand(0, count($boxes) - 1);
    $left = $boxes[$index];
    $right = $boxes[1 - $index];

    load_results($left, $UFL_SEARCH_BOXES[$left], $query);
    load_results($right, $UFL_SEARCH_BOXES[$right], $query, 'right');
}

function load_results($box, $url_format, $query, $side = 'left') {
?>
    <div id="<?php echo htmlspecialchars($side); ?>">
      <form method="post" class="choice">
        <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>" />
        <input type="hidden" name="box" value="<?php echo htmlspecialchars($box); ?>" />
        <input type="submit" value="<?php echo htmlspecialchars(ucfirst($side)); ?>-hand side is better" />
        <img src="images/loading.gif" width="16" height="16" alt="Loading..." class="loading" />
        <img src="images/success.png" width="16" height="16" alt="Success!" class="success" />
      </form>
      <iframe src="<?php echo htmlspecialchars(sprintf($url_format, $query)); ?>"></iframe>
    </div><!-- #<?php echo htmlspecialchars($side); ?> -->
<?php
}

function log_choice($ip, $query, $box) {
    /*
       CREATE TABLE search_comparison_choices (
           id MEDIUMINT NOT NULL AUTO_INCREMENT,
           ip VARCHAR(15) NOT NULL,
           query VARCHAR(1024) NOT NULL,
           box VARCHAR(7) NOT NULL,
           PRIMARY KEY (id)
       );
    */
    $sql = "INSERT INTO search_comparison_choices (ip, query, box) VALUES ('%s', '%s', '%s')";

    return query_database($sql, array($ip, $query, $box));
}

function is_winner($box, $results) {
    // Handle ties by counting wins and comparing to number of candidates
    $num_wins = 0;
    foreach (array_keys($results) as $candidate_box) {
        if ($results[$box] > $results[$candidate_box] or $candidate_box == $box) {
            $num_wins++;
        }
    }

    return ($num_wins == count(array_keys($results)));
}
?>
