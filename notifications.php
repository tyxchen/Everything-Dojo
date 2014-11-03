<?php

  include("include/include.php");

  session_start();

// main loop
if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === "xmlhttprequest")) {

  if (isset($_SESSION['user_id'])) {
    $timestamp = isset($_GET['timestamp']) ? intval($_GET['timestamp']) : NULL;
    $last_notification_timestamp = $notification->get_last_notification_timestamp($_SESSION['user_id']);

    if ($timestamp === NULL || $timestamp > $last_notification_timestamp) {
      $notif = $notification->get_notifications($_SESSION['user_id'], 1)[0];
      $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);

      $result = array(
        'id' => $notif['id'],
        'timestamp' => date('D M d, Y g:i a', $notif['timestamp']),
        'data' => array(
          'text' => $notif_data['data']['subject'],
          'color' => $notif_data['data']['color'],
          'url' => $notif_data['url'],
          'read' => $notif['read']
        )
      );

      $json = json_encode($result);

      echo $json;
    }
  } else
    echo json_encode(array('data'=>array('text' => 'Hey, you\'re not logged in!')));

  exit();
}


?>

<?php
  $title = "Notifications";
  $extra_js = "<script>$(function(){\$('.notification-link').hide()})</script>";

  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id'], 1000);
  }

  get_header(0);
?>
<section id="content">
  <div id="notifications-test">
    <div id="notification-body" style="width:95%;margin:auto">
      <div id="notification-header" style="width:100%">
        <b>notifications:</b>
        <a href="javascript:;" style="float: right; margin-right: 2vw;" onclick="mark_all_read(<?php echo $_session['user_id']; ?>)">mark all read</a>
      </div>
      <?php if (count($notification_data) == 0) { ?>
      <a href="javascript:;">
      <div id="notification-0" class="notification-item read">
        <div class="notification-color" style="background-color: #ccc"></div>
        <div class="notification-text">no notifications</div>
      </div>
      </a>
      <?php
      } else {
        foreach ($notification_data as $notif) {
          $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
      ?>
      <a href="<?php echo $notif_data['url']; ?>" class="notification-item-link" onclick="mark_read(<?php echo $notif['id']; ?>)">
        <div id="notification-<?php echo $notif['id']; ?>" class="notification-item <?php if ($notif['read'] == 0) { echo 'unread'; } else { echo 'read'; } ?>" style="border-bottom:none">
          <div class="notification-color" style="background-color: #<?php echo $notif_data['data']['color']; ?>"><?php echo substr($notif_data['data']['location'], 0, 1); ?></div>
          <div class="notification-text">
            <?php echo $notif_data['data']['subject']; ?>
          </div>
          <p class="time">
             <?php echo date('D M d, Y g:i a', $notif['timestamp']); ?>
          </p>
        </div>
      </a>
      <?php
        }
      }
      ?>
    </div>
  </div>

</section>

<?php get_footer(0); ?>
