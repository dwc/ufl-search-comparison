<?php
include_once('connection.php');


function display_ui($query) {
    $boxes = array('googlea', 'googleb');

    $index = rand(0, count($boxes) - 1);
    $left = $boxes[$index];
    $right = $boxes[1 - $index];

    load_results($left, $query);
    load_results($right, $query, 'right');
}

function load_results($box, $query, $side = 'left') {
    $url_format = 'http://%s.ns.ufl.edu/search?q=%s&btnG=Google+Search&access=p&entqr=3&output=xml_no_dtd&sort=date%%3AD%%3AL%%3Ad1&entsp=0&client=default_frontend&ud=1&oe=UTF-8&ie=UTF-8&proxystylesheet=default_frontend&site=default_collection';
?>
    <div id="<?php echo htmlspecialchars($side); ?>">
      <form method="post" class="choice">
        <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>" />
        <input type="hidden" name="box" value="<?php echo htmlspecialchars($box); ?>" />
        <input type="submit" value="<?php echo htmlspecialchars(ucfirst($side)); ?>-hand side is better" />
      </form>
      <iframe src="<?php echo htmlspecialchars(sprintf($url_format, $box, $query)); ?>"></iframe>
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
    query_database($sql, array($ip, $query, $box));
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
