<?php
$query = $_GET['query'];
?>
<html>
  <head>
    <title>Search Comparison</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
  </head>
  <body>
    <h1>Search Comparison</h1>
    <p>Enter a query and then choose the results below that you think are better.</p>
    <form method="get" id="query">
      <input type="text" name="query" value="<?php echo htmlspecialchars($query); ?>" />
      <input type="submit" value="Search" />
    </form>
<?php if ($query): include('includes/ui.php'); endif; ?>
  </body>
</html>
