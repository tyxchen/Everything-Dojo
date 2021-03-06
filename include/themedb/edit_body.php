<?php
$id = $_GET['id'];
$edit = $themedb->check_owner($id, $_SESSION['user_id']);
if ($edit == false && checkAdmin() == 0) {
  redirect(URL_DATABASE);
} else {
  if (!checkAdmin()) {
    $style = $themedb->get_themes($id, false, $_SESSION['user_id']);
  } else {
    $style = $themedb->get_themes($id, false, $_SESSION['user_id'], 1);
  }
  $development_stages = array('[DEV]', '[ALPHA]', '[BETA]');
?>
 >> <?php if ($style['validated'] == 1) { ?><a href="<?php echo URL_DATABASE; ?>?mode=view&view=complete">Completed Themes</a><?php }else{?><a href="<?php echo URL_DATABASE; ?>?mode=view&view=development">Development Themes</a> <?php } ?> >> <a href="<?php echo URL_DATABASE;?>?mode=view&view=style&id=<?php echo $id; ?>">View Theme</a>
<h2>Edit Theme</h2>
<form method="post" action="/include/db-handler.php">
  <div class="col" id="col1">
    <label>Theme name:</label>
    <input type="text" name="name" value="<?php echo $style['name']; ?>" /><br />
    <label>Theme author:</label>
    <input type="text" name="author" value="<?php echo $style['author']; ?>" />
  </div>
  <div class="col" id="col2">
    <label>Theme screenshot (url):</label>
    <input type="text" name="screenshot" value="<?php echo $style['screenshot']; ?>" /><br />
    <label>Theme version (e.g. 1.2):</label>
    <input type="text" name="version" value="<?php echo $style['version']; ?>" />
  </div>
  <div class="col" id="col3">
    <label>Theme stage:</label>
    <?php if (in_array($style['stage'], $development_stages)) { ?>
    <input type="radio" name="stage" value="[DEV]" id="[DEV]" <?php if($style['stage'] == '[DEV]'){ ?>checked="yes"<?php } ?> /><label for="[DEV]" class="inline">[DEV]</label><br />
    <input type="radio" name="stage" value="[ALPHA]" id="[ALPHA]" <?php if($style['stage'] == '[ALPHA]'){ ?>checked="yes"<?php } ?> /><label for="[ALPHA]" class="inline">[ALPHA]</label><br />
    <input type="radio" name="stage" value="[BETA]" id="[BETA]" <?php if($style['stage'] == '[BETA]'){ ?>checked="yes"<?php } ?> /><label for="[BETA]" class="inline">[BETA]</label>
    <?php } else { ?>
    <input type="radio" name="stage" value="[RELEASE]" id="[RELEASE]" checked="yes" /><label for="[RELEASE]" class="inline">[RELEASE]</label>
    <?php } ?>
  </div>
  <div id="fields">
    <label>Theme Description (optional):</label>
    <textarea id="description" name="description"><?php echo $style['description']; ?></textarea><br />
    <label>Theme CSS:</label>
    <textarea id="css" name="code"><?php echo $style['code']; ?></textarea>
    <input type="submit" name="submit" style="font-size: 15px;" />
    <input type="hidden" name="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="mode" value="edit-theme" />
  </div>
</form>
<?php } ?>
