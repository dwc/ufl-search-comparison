<?php
include_once('../includes/connection.php');
include_once('../includes/functions.php');

$totals_result = query_database("SELECT box, COUNT(*) FROM search_comparison_choices GROUP BY box");

$totals = array();
$results = array();
while (list($box, $total) = mysql_fetch_row($totals_result)) {
    $totals[$box] = $total;

    $sql = "SELECT query, COUNT(*) FROM search_comparison_choices WHERE box = '%s' GROUP BY query";
    $results_result = query_database($sql, array($box));
    while (list($query, $count) = mysql_fetch_row($results_result)) {
        $results[$query][$box] = $count;
    }

}

$boxes = array_keys($totals);
sort($boxes);

$queries = array_keys($results);
sort($queries);
?>
<html>
  <head>
    <title>Search Comparison</title>
    <link rel="stylesheet" type="text/css" href="../main.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="checkbox.js"></script>
    <script type="text/javascript" src="graph.js"></script>
  </head>
  <body>
    <h1>Search Comparison</h1>
    <p>The results by query are shown below. Check one or more query to compare the results on the graph.</p>
    <table id="results">
      <thead>
        <tr>
          <th><input type="checkbox" id="all" /></th>
          <th>Query</th>
<?php foreach ($boxes as $box): ?>
          <th class="choice"><?php echo htmlspecialchars($box); ?></th>
<?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
<?php foreach ($queries as $query): ?>
        <tr>
          <td><input type="checkbox" name="query" value="<?php echo htmlspecialchars($query); ?>" /></td>
          <td><a href="../?query=<?php echo htmlspecialchars(urlencode($query)); ?>"><?php echo htmlspecialchars($query); ?></a></td>
<?php     foreach ($boxes as $box): ?>
<?php         $result = array_key_exists($box, $results[$query]) ? $results[$query][$box] : 0; ?>
<?php         $is_winner = false; if (is_winner($box, $results[$query])): $is_winner = true; endif; ?>
          <td class="result"><?php if ($is_winner): ?><strong><?php endif; ?><?php echo htmlspecialchars($result); ?><?php if ($is_winner): ?></strong><?php endif; ?></td>
<?php     endforeach; ?>
        </tr>
<?php endforeach; ?>
        <tr id="total">
          <td><input type="checkbox" name="query" value="(Total)" id="total" checked="checked" /></td>
          <td>(Total)</td>
<?php     foreach ($boxes as $box): ?>
<?php         $result = array_key_exists($box, $totals) ? $totals[$box] : 0; ?>
<?php         $is_winner = false; if (is_winner($box, $totals)): $is_winner = true; endif; ?>
          <td class="result"><?php if ($is_winner): ?><strong><?php endif; ?><?php echo htmlspecialchars($result); ?><?php if ($is_winner): ?></strong><?php endif; ?></td>
<?php     endforeach; ?>
        </tr><!-- #total -->
      </tbody>
    </table><!-- #results -->
  </body>
</html>
