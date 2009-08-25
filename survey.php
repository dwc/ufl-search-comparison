<?php
include_once('includes/functions.php');


$show_intro = false;
$show_outro = false;
$query = '';

if (survey_started()) {
    $query = current_query();

    if ($_POST['query'] and $_POST['choice']) {
        log_choice(session_id(), $_POST['query'], $_POST['choice']);

        // Continue survey
        $query = next_query();
    }

    if (survey_finished()) {
        $show_outro = true;
    }
}
elseif ($_POST['begin']) {
    load_queries();
    $query = current_query();
}
else {
    $show_intro = true;
}
?>
<html>
  <head>
    <title>Search Survey</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <!--[if IE]>
      <link rel="stylesheet" type="text/css" href="ie.css" />
    <![endif]-->
  </head>
  <body>
    <h1>Search Survey</h1>
<?php if ($show_intro): ?>
    <p>Thank you for expressing interest in helping the University of Florida with its Web site search service. In this survey, you will be asked to compare search results for <?php echo htmlspecialchars(UFL_SEARCH_MAX_QUERIES); ?> quer<?php echo (UFL_SEARCH_MAX_QUERIES == 1 ? 'y' : 'ies'); ?> and choose the set you think is better. Please use your best judgment if you run across a query that you are not familiar with.</p>
    <p>Note: Your choices are completely anonymous.</p>
    <form method="post">
      <input type="submit" name="begin" value="Start Survey" />
    </form>
<?php elseif ($show_outro): ?>
    <p>Thanks for participating! Your selections have been recorded.</p>
    <p>We will be using your data in the future as we perform upgrades to the <a href="http://www.ufl.edu/">University of Florida</a> <a href="http://search.ufl.edu/">Web site search service</a>.</p>
<?php elseif ($query): ?>
    <h2><?php echo htmlspecialchars(survey_progress()); ?></h2>
    <h3>Query: <em><?php echo htmlspecialchars($query); ?></em></h3>
<?php     display_ui($query); ?>
<?php else: ?>
    <p>Error</p>
<?php endif; ?>
  </body>
</html>
