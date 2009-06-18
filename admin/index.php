<?php
include_once('../includes/connection.php');
include_once('../includes/functions.php');

$box_result = query_database('SELECT DISTINCT(box) FROM search_comparison_choices');

$boxes = array();
$results = array();
while (list($box) = mysql_fetch_row($box_result)) {
    $boxes[] = $box;

    $sql = "SELECT query, COUNT(*) FROM search_comparison_choices WHERE box = '%s' GROUP BY query";
    $query_result = query_database($sql, array($box));
    while (list($query, $count) = mysql_fetch_row($query_result)) {
        $results[$query][$box] = $count;
    }
}
?>
<html>
  <head>
    <title>Search Comparison</title>
    <link rel="stylesheet" type="text/css" href="../main.css" />
  </head>
  <body>
    <h1>Search Comparison</h1>
    <p>The results by query are shown below. Check one or more query to compare the results on the graph.</p>
    <table>
      <thead>
        <tr>
          <th><input type="checkbox" /></th>
          <th>Query</th>
<?php foreach ($boxes as $box): ?>
          <th><?php echo htmlspecialchars($box); ?></th>
<?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
<?php $queries = array_keys($results); ?>
<?php sort($queries); ?>
<?php foreach ($queries as $query): ?>
        <tr>
          <td><input type="checkbox" name="query" value="<?php echo htmlspecialchars($query); ?>" /></td>
          <td><a href="../?query=<?php echo htmlspecialchars(urlencode($query)); ?>"><?php echo htmlspecialchars($query); ?></a></td>
<?php     foreach ($boxes as $box): ?>
<?php         $result = array_key_exists($box, $results[$query]) ? $results[$query][$box] : 0; ?>
<?php         $is_winner = false; if (is_winner($box, $results[$query])): $is_winner = true; endif; ?>
          <td><?php if ($is_winner): ?><strong><?php endif; ?><?php echo htmlspecialchars($result); ?><?php if ($is_winner): ?></strong><?php endif; ?></td>
<?php     endforeach; ?>
        </tr>
<?php endforeach; ?>
      </tbody>
    </table>
  </body>
</html>
