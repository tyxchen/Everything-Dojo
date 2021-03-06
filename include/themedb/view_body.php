<?php
  $data = $themedb->get_themes();
  $view = $_GET['view'];

  $tableHeader = '
  <thead>
    <tr class="headingTr">
      <td>Theme</td>
      <td class="med-col">Author</td>
      <td class="small-col">Version</td>
      <td class="small-col">Stage</td>
    </tr>
  </thead>
  ';

  switch ($view) {
    case '';
?>
  <div id="tile-container">
     <a href="<?php echo URL_DATABASE; ?>?mode=view&view=complete" class="database-link">
     <div class="db-tile db-tile-large" id="complete">
       <div class="db-tile-inner">
        <span class="db-tile-title">Completed</span><br />Themes on this page have been validated by a theme moderator. These themes are bug free and can be used in your blog without worry.
      </div>
    </div>
    </a>
    <a href="<?php echo URL_DATABASE; ?>?mode=view&view=development" class="database-link">
    <div class="db-tile db-tile-large" id="development">
      <div class="db-tile-inner">
        <span class="db-tile-title">Development</span><br />Themes on this page have been approved, but not yet validated. They are still in development and may have some bugs that need to be ironed out.
      </div>
    </div>
    </a>
  </div>
<?php
      break;
    case 'complete';
?>
    <h2>Completed Themes</h2>

    <table class="database-table">
      <?php echo $tableHeader; ?>
      <tbody>
      <?php
      for ($i = 0; $i < count($data['validated']['id']); $i++) {
        $description = shorten_desc($data['validated']['description'][$i]);
      ?>
        <tr class="style" onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['validated']['id'][$i]; ?>'">
          <td><?php echo "<b>".$data['validated']['name'][$i]."</b><br />" . $description; ?></td>
          <td><?php echo $data['validated']['author'][$i]; ?></td>
          <td><?php echo $data['validated']['version'][$i]; ?></td>
          <td><?php echo $data['validated']['stage'][$i]; ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
<?php
      break;
    case 'development':
?>
    <h2>Themes in Development</h2>

    <table class="database-table">
      <?php echo $tableHeader; ?>
      <tbody>
      <?php
      for ($i = 0; $i < count($data['unvalidated']['id']); $i++) {
        $description = shorten_desc($data['unvalidated']['description'][$i]);
      ?>
        <tr class="style" onclick="document.location = '<?php echo URL_DATABASE; ?>?mode=view&view=style&id=<?php echo $data['unvalidated']['id'][$i]; ?>'">
          <td><?php echo "<b>".$data['unvalidated']['name'][$i]."</b><br />".$description; ?></td>
          <td><?php echo $data['unvalidated']['author'][$i]; ?></td>
          <td><?php echo $data['unvalidated']['version'][$i]; ?></td>
          <td><?php echo $data['unvalidated']['stage'][$i]; ?></td>
        </tr>
      <?php
      }
      ?>
      </tbody>
    </table>
<?php
      break;
    case 'style':
      $id = $_GET['id'];
      if ($_SESSION['user_level'] >= 4) {
        $moderator = 1;
      } else {
        $moderator = 0;
      }
      $edit = $themedb->check_owner($id, $_SESSION['user_id']);
      $style = $themedb->get_themes($id, false, $_SESSION['user_id'], $moderator);
?>
 >> <?php if ($style['validated'] == 1) { ?><a href="<?php echo URL_DATABASE; ?>?mode=view&view=complete">Completed Themes</a><?php }else{?><a href="<?php echo URL_DATABASE; ?>?mode=view&view=development">Development Themes</a> <?php } ?>

<?php
      if($id == '' || count($style) == 0){
?>
      This style does not exist.
<?php
      } else {
?>

<h2 class="view-header"><?php echo $style['name']; ?> v<?php echo $style['version']; ?> by <?php echo $style['author']; ?> <?php echo $style['stage']; ?></h2>
<div id="popup-box">
  <h2 id="popup-header"></h2>
  <span style="color: white;">Confirm your action in the box below.</span>
  <div id="popup-wrapper">
    <div id="popup-inner">
      <div id="popup-form">
        <p>Are you sure you want to <span id="replace"></span> this theme?</p>
        <form action="/include/db-handler.php" method="post">
          <input type="submit" name="submit" value="Confirm" style="font-size: 15px;" />
          <input type="hidden" value="" name="id" id="replace-id" />
          <input type="hidden" value="" name="mode" id="replace-form" />
        </form>
      </div>
    </div>
  </div>
</div>
<div id="theme">
  <?php if ($edit == TRUE || checkAdmin()){ ?><a href="<?php echo URL_DATABASE; ?>?mode=edit&id=<?php echo $id; ?>"><img src="../../images/edit.png" class="img-edit" /> Edit Theme</a> <a href="<?php echo URL_DATABASE; ?>?mode=settings&id=<?php echo $id; ?>"><img src="../../images/gear.png" class="img-edit" /> Manage Settings</a> <a href="javascript:;" class="view" onclick="popup_options('delete', <?php echo $style['id']; ?>);"><img src="../../images/trash.png" class="img-edit" /> Delete Theme</a><?php } ?>
  <section><?php echo $style['description']; ?></section>
  <section>
    <label><b>Screenshot:</b></label>
    <img src="<?php echo $style['screenshot']; ?>" style="max-width: 65vw" />
  </section>
  <section>
    <a href="<?php echo '/tryit/?select=' . $_GET['id'] . (in_array($style['stage'], array('[ALPHA]','[BETA]','[DEV]')) ? '&dev=dev' : '')?>">View this style in the Try-It!</a>
  </section>
  <section>
    <label><b>Code:</b></label>
    <div class="code">
      <pre>
        <code class="language-css"><?php echo nl2br($style['code']); ?></code>
      </pre>
    </div>
  </section>
</div>
  <?php
      }
      break;
    }
  ?>
