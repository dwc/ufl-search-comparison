<?php
include_once('includes/functions.php');


if ($_POST['query'] and $_POST['box']) {
    log_choice($_SERVER['REMOTE_ADDR'], $_POST['query'], $_POST['box']);
}

$queries = file_get_contents('queries.txt');
$queries = split("\n", $queries);

$query = $queries[rand(0, count($queries) - 1)];
?>
<html>
  <head>
    <title>Popularity Contest</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
  </head>
  <body>
    <h1>Popularity Contest</h1>
    <p>For the query <em><?php echo htmlspecialchars($query); ?></em>, choose the results below that you think are better.</p>
<?php display_ui($query); ?>
  </body>
</html>
