<?php
include('includes/box.php');

$query = $_GET['query'];
?>
<html>
  <head>
    <title>Search Comparison</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
  </head>
  <body>
    <h1>Search Comparison</h1>
    <p>Enter a query and choose the results below that you think are better.</p>
    <form method="get">
      <input type="text" name="query" value="<?php echo htmlspecialchars($query); ?>" />
      <input type="submit" value="Search" />
    </form>
<?php include('includes/ui.php'); ?>
  </body>
</html>
