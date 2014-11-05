
<?php

  include("../include/include.php");

  session_start();

  header('Content-Type: text/event-stream');
  header('Cache-Control: no-cache'); // recommended to prevent caching of event data.


  // begin streaming
//  if ((isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === "xmlhttprequest")) {

//  while (TRUE) {
    if (isset($_SESSION['user_id'])) {
      $timestamp = isset($_GET['timestamp']) ? intval($_GET['timestamp']) : NULL;
      $last_notification_timestamp = $notification->get_last_notification_timestamp($_SESSION['user_id']);

      if ($timestamp !== 0 && $timestamp < $last_notification_timestamp) {
        $notif = $notification->get_notifications($_SESSION['user_id'], 1)[0];
        $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);

        if (intval($notif['read']) === 0) {
          $result = array(
            'id' => $notif['id'],
            'user_id' => $_SESSION['user_id'],
            'date' => date('D M d, Y g:i a', $notif['timestamp']),
            'timestamp' => $last_notification_timestamp,
            'data' => array(
              'text' => $notif_data['data']['subject'],
              'color' => $notif_data['data']['color'],
              'url' => $notif_data['url'],
              'read' => $notif['read']
            )
          );
        } else {
          $result = array(
            'timestamp' => $last_notification_timestamp
          );
        }

      } else {
        $result = array(
          'timestamp' => $last_notification_timestamp
        );
      }

//      echo 'data: ' . implode('\n', json_encode($result)) . '\n';
      echo "data: {'timestamp':" . time() . "}\n";
      ob_flush();
      flush();
    } else {
      echo 'data: ' . json_encode(array('data' => 'Please log in', 'timestamp' => time())) . '\n\n';
      exit();
    }

    sleep(1);
//  }
//  }
