<?php
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

function log_choice($query, $box) {
}
?>
