<?php
include("include/include.php");

$table = TB_NAME;
page_protect();

$err = array();
$msg = array();

if (isset($_POST['doUpdate'])) {

  $rs_pwd = $dbc->prepare("SELECT pwd FROM $table WHERE id=?");
  $rs_pwd->execute(array($_SESSION['user_id']));
  $rs_pwd = $rs_pwd->fetchAll(PDO::FETCH_ASSOC);
  list($old) = $rs_pwd;
  $old_salt = substr($old['pwd'], 0, 9);

  //check for old password in md5 format
  if (password_verify($_POST['pwd_old'], $old['pwd'])) {
    if (checkPwd($_POST['pwd_new'], $_POST['pwd_again'])) {
      $newsha1 = PwdHash($_POST['pwd_new']);
      $result = $dbc->prepare("UPDATE $table SET pwd = ? WHERE id = ?");
      $result->execute(array($newsha1,$_SESSION['user_id']));
      $msg[] = "Your password has been updated!";
    } else {
      $err[] = "Passwords must be at least 6 characters long, or your new passwords don't match.";
    }
  } else {
    $err[] = "Your old password is incorrect. Please check your spelling and try again.";
  }

}

/* if you decide to add profile settings (address, name, telephone, dumb things like that i never need)
if(isset($_POST['doSave'])) {

  foreach($_POST as $key => $value) {
    $data[$key] = filter($value);
  }

  mysql_query("UPDATE ".$table." SET user_email = \"".$data['user_email']."\" WHERE id=\"".$_SESSION['user_id']."\"") or die(mysql_error());

  $msg[] = "Profile sucessfully updated!";
}

then loop
while ($row_settings = mysql_fetch_array($rs_settings)) {}
and output a bunch of forms
*/

$rs_settings = $dbc->prepare("SELECT * FROM $table WHERE id = ?");
$rs_settings->execute(array($_SESSION['user_id']));
?>
<?php
  $title = "My Settings";
  //dbc already included
  page_protect();

  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }

  get_header(0);
?>
<section id="content">
  <?php notifications(); ?>

  <?php //spit out all errors
  if (!empty($err)) {
    echo "<p id=\"errors\">";
    foreach ($err as $e) {
      echo "Error: ".$e."<br />";
    }
    echo "</p>";
  }

  if (!empty($msg)) {
    echo "<div class=\"msg\">".$msg[0]."</div>";
  } else { ?>
  <h2>My Settings</h2>
  <p>Here you can make changes to your profile. Right now, the only thing you can change is your password.</p>
  <form name="pform" id="pform" method="post" action="mysettings.php">
    <label>Old Password</label>
    <input type="password" name="pwd_old">
    <label>New Password</label>
    <label class="small i">Must be at least 6 characters long.</label>
    <input type="password" name="pwd_new">
    <label>Retype Password</label>
    <input type="password" name="pwd_again">
    <input type="submit" name="doUpdate">
  </form>
  <?php } //end no msg ?>
</section>
<?php get_footer(0); ?>
