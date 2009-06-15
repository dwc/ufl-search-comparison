    <div id="left">
      <form method="post">
        <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>" />
        <input type="hidden" name="box" value="<?php echo htmlspecialchars($left); ?>" />
        <input type="submit" value="Left-hand side is better" />
      </form>
      <iframe src="<?php echo htmlspecialchars(sprintf($url_format, $left, $query)); ?>"></iframe>
    </div><!-- #left -->

    <div id="right">
      <form method="post">
        <input type="hidden" name="query" value="<?php echo htmlspecialchars($query); ?>" />
        <input type="hidden" name="box" value="<?php echo htmlspecialchars($right); ?>" />
        <input type="submit" value="Right-hand side is better" />
      </form>
      <iframe src="<?php echo htmlspecialchars(sprintf($url_format, $right, $query)); ?>"></iframe>
    </div><!-- #right -->
