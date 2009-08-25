<?php
include_once('../includes/connection.php');
include_once('../includes/functions.php');


$totals_result = query_database("SELECT choice, COUNT(*) FROM search_comparison_choices GROUP BY choice");

$totals = array();
$results = array();
while (list($choice, $total) = mysql_fetch_row($totals_result)) {
    $totals[$choice] = $total;

    $sql = "SELECT query, COUNT(*) FROM search_comparison_choices WHERE choice = '%s' GROUP BY query";
    $results_result = query_database($sql, array($choice));
    while (list($query, $count) = mysql_fetch_row($results_result)) {
        $results[$query][$choice] = $count;
    }
}

$choices = array_keys($totals);
sort($choices);

$queries = array_keys($results);
sort($queries);
?>
<html>
  <head>
    <title>Search Comparison</title>
    <link rel="stylesheet" type="text/css" href="../main.css" />
    <!--[if IE]>
      <link rel="stylesheet" type="text/css" href="../ie.css" />
    <![endif]-->
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="graph.js"></script>
  </head>
  <body>
    <h1>Search Comparison</h1>
<?php if ($results): ?>
    <p>The results by query are shown below. Check one or more query to compare the results on the graph.</p>
    <table id="results">
      <thead>
        <tr>
          <th>&nbsp;</th>
          <th>Query</th>
<?php     foreach ($choices as $choice): ?>
          <th class="choice"><?php echo htmlspecialchars($choice); ?></th>
<?php     endforeach; ?>
        </tr>
      </thead>
      <tbody>
<?php     foreach ($queries as $query): ?>
        <tr>
          <td><input type="checkbox" name="query" value="<?php echo htmlspecialchars($query); ?>" /></td>
          <td><a href="../?query=<?php echo htmlspecialchars(urlencode($query)); ?>"><?php echo htmlspecialchars($query); ?></a></td>
<?php         foreach ($choices as $choice): ?>
<?php             $result = array_key_exists($choice, $results[$query]) ? $results[$query][$choice] : 0; ?>
<?php             $is_winner = false; if (is_winner($choice, $results[$query])): $is_winner = true; endif; ?>
          <td class="result"><?php if ($is_winner): ?><strong><?php endif; ?><?php echo htmlspecialchars($result); ?><?php if ($is_winner): ?></strong><?php endif; ?></td>
<?php         endforeach; ?>
        </tr>
<?php     endforeach; ?>
        <tr id="total">
          <td><input type="checkbox" name="query" value="(Total)" id="total" checked="checked" /></td>
          <td>(Total)</td>
<?php     foreach ($choices as $choice): ?>
<?php         $result = array_key_exists($choice, $totals) ? $totals[$choice] : 0; ?>
<?php         $is_winner = false; if (is_winner($choice, $totals)): $is_winner = true; endif; ?>
          <td class="result"><?php if ($is_winner): ?><strong><?php endif; ?><?php echo htmlspecialchars($result); ?><?php if ($is_winner): ?></strong><?php endif; ?></td>
<?php     endforeach; ?>
        </tr><!-- #total -->
      </tbody>
    </table><!-- #results -->
<?php else: ?>
    <p>No results so far.</p>
<?php endif; ?>
  </body>
</html>
