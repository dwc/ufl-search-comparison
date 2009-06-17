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
      <form method="post">
        <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>" />
        <input type="hidden" name="box" value="<?php echo htmlspecialchars($box); ?>" />
        <input type="submit" value="<?php echo htmlspecialchars(ucfirst($side)); ?>-hand side is better" />
      </form>
      <iframe src="<?php echo htmlspecialchars(sprintf($url_format, $box, $query)); ?>"></iframe>
    </div><!-- #<?php echo htmlspecialchars($side); ?> -->
<?php
}

function log_choice($ip, $query, $box) {
    global $db;

    /*
       CREATE TABLE search_comparison_choices (
           id MEDIUMINT NOT NULL AUTO_INCREMENT,
           ip VARCHAR(15) NOT NULL,
           query VARCHAR(1024) NOT NULL,
           box VARCHAR(7) NOT NULL,
           PRIMARY KEY (id)
       );
     */
    $result = mysql_query("INSERT INTO search_comparison_choices (ip, query, box) VALUES ('" . mysql_escape_string($ip) . "', '" . mysql_escape_string($query) . "', '" . mysql_escape_string($box) . "')", $db);
    if (! $result) {
        die('Invalid query: ' . mysql_error());
    }
}

function get_chart_url($data, $width = 250, $height = 58, $colors = array('FF0000', '0000FF')) {
    $chart_url_format = 'http://chart.apis.google.com/chart?cht=%s&chs=%dx%d&chd=t:%s&chds=%s&chco=%s';

    $max = max($data);
    $chart_url = sprintf($chart_url_format, 'bhs', $width, $height, join(',', $data), "0,$max", join('|', $colors));

    return $chart_url;
}
?>
