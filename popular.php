<?php
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
<?php include('includes/ui.php'); ?>
  </body>
</html>
