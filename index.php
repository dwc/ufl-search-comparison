<?php
include_once('includes/functions.php');

if ($_POST['query'] and $_POST['box']) {
    log_choice($_SERVER['REMOTE_ADDR'], $_POST['query'], $_POST['box']);

    if ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
        die("ok");
    }
}

$query = stripslashes($_REQUEST['query']);
?>
<html>
  <head>
    <title>Search Comparison</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
    <script type="text/javascript" src="choose.js"></script>
  </head>
  <body>
    <h1>Search Comparison</h1>
    <p>Enter a query and then choose the results below that you think are better.</p>
    <form method="get" id="query">
      <input type="text" name="query" value="<?php echo htmlspecialchars($query); ?>" />
      <input type="submit" value="Search" />
    </form>
    <div id="loading">Loading...</div>
<?php if ($query): display_ui($query); endif; ?>
  </body>
</html>
