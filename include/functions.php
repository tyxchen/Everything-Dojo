<?php
  /* FUNCTIONS */
  //Generally linked to the login system.

  /* Page Protect: Redirects to index.php if visiting a page while not logged in that is protected by this function.*/
  function page_protect() {
    session_start();

    global $db;

    /* Secure against session hijacking by checking user agent & user ip */
    if (isset($_SESSION['HTTP_USER_AGENT']) && (isset($_SESSION['HTTP_X_FORWARDED_FOR']) || isset($_SESSION['REMOTE_ADDR']))) {
      if ($_SESSION['HTTP_USER_AGENT'] != sha1($_SERVER['HTTP_USER_AGENT']) && ($_SESSION['HTTP_X_FORWARDED_FOR'] != sha1($_SERVER['HTTP_X_FORWARDED_FOR']) || $_SESSION['REMOTE_ADDR'] != sha1($_SERVER['REMOTE_ADDR']))) {
        logout();
        exit();
      }
    }

    if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) ) {
      header("Location: index.php");
      exit();
    }
  }

  function get_user($user_id) {
    global $dbc;

    $sth = $dbc->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $sth->execute(array(
      ':id' => intval($user_id)
    ));
    $name = $sth->fetch(PDO::FETCH_ASSOC);
    $name = $name['user_name'];
    return $name;
  }
  
  function get_user_info($user_id) { /*Would like to see this and get_user() combined in the near future*/
    global $dbc;

    $sth = $dbc->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $sth->execute(array(
      ':id' => intval($user_id)
    ));
    $user = $sth->fetch(PDO::FETCH_ASSOC);
    return $user;
  }

  function get_all_user($user_id) {
    global $dbc;

    $sth = $dbc->prepare("SELECT * FROM `users` WHERE `id` = :id");
    $sth->execute(array(
      ':id' => intval($user_id)
    ));
    $user = $sth->fetchAll(PDO::FETCH_ASSOC);
    return $user[0];
  }


  function filter($data) {
    $data = trim(addslashes(htmlentities(strip_tags($data))));

    if (get_magic_quotes_gpc())
      $data = stripslashes($data);

    return $data;
  }

  function EncodeURL($url) {
    $new = strtolower(ereg_replace(' ','_',$url));
    return($new);
  }

  function DecodeURL($url) {
    $new = ucwords(ereg_replace('_',' ',$url));
    return($new);
  }

  function ChopStr($str, $len) {
    if (strlen($str) < $len)
      return $str;

    $str = substr($str,0,$len);
    if ($spc_pos = strrpos($str," "))
        $str = substr($str,0,$spc_pos);

    return $str . "...";
  }

  function isEmail($email) {
    return preg_match('/^\S+@[\w\d.-]{2,}\.[a-z]{2,6}$/iU', $email) ? TRUE : FALSE;
  }

  function isUserID($username) {
    if (preg_match('/^[a-z\d_]{3,20}$/i', $username)) {
      return true;
    } else {
      return false;
    }
  }

  function isURL($url) {
    if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
      return true;
    } else {
      return false;
    }
  }

  function checkPwd($x, $y) {
    if(empty($x) || empty($y) ) { return false; }
    if (strlen($x) < 6 || strlen($y) < 6) { return false; }

    if (strcmp($x, $y) != 0) {
      return false;
    }
    return true;
  }

  function GenPwd($length = 7) {
    $password = "";
    $possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels

    $i = 0;

    while ($i < $length) {
      $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

      if (!strstr($password, $char)) {
        $password .= $char;
        $i++;
      }
    }

    return $password;

  }

  function GenKey($length = 7) {
    $password = "";
    $possible = "0123456789abcdefghijkmnopqrstuvwxyz";

    $i = 0;

    while ($i < $length) {

      $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);

      if (!strstr($password, $char)) {
        $password .= $char;
        $i++;
      }

    }

    return $password;
  }

  function logout() {
    global $dbc;
    session_start();

    $table = TB_NAME;
    if(isset($_SESSION['user_id'])) {
      $result = $dbc->prepare("UPDATE $table SET ckey = '', ctime = '' WHERE id = ?");
      $result->execute(array($_SESSION['user_id']));
    }

    //delete the session information
    unset($_SESSION['user_id']);
    unset($_SESSION['user_name']);
    unset($_SESSION['user_level']);
    unset($_SESSION['HTTP_USER_AGENT']);
    session_unset();
    session_destroy();

    header("Location: index.php?msg=You have been successfully logged out.");
  }

  // Password and salt generation
  function PwdHash($pwd) {
//    include("include/password.php");
    return password_hash($pwd, PASSWORD_BCRYPT);
  }

  function checkAdmin() {
    if ($_SESSION['user_level'] == ADMIN_LEVEL) {
      return 1;
    } else {
      return 0;
    }
  }

  function stringtoHTML($string) {
    $striphtml = strip_tags($string, '<a><b><i><u><ul><ol><li>');
    $explodeparagraphs = explode("\r\n\r\n", $string);
    array_filter($explodeparagraphs);
    $numparagraphs = count($explodeparagraphs);
    for ($i = 0; $i < $numparagraphs; $i++) {
      $thisparagraph = $explodeparagraphs[$i];
      $thisparagraph = str_replace( "\n", '<br />', $thisparagraph);
      $explodeparagraphs[$i] = "<p>".$thisparagraph."</p>";
    }
    $implode = addslashes(implode($explodeparagraphs)); //add slashes for PHP escaping
    return $implode;
  }

  function HTMLtostring($html) {
    $explode = explode("</p><p>", $html);
    $numparagraphs = count($explode);
    $explode[0] = substr($explode[0], 3);
    $explode[$numparagraphs - 1] = substr($explode[$numparagraphs - 1], 0, -4);
    for ($i = 0; $i < $numparagraphs; $i++) {
      $explode[$i] = str_replace('<br />', "\n", $explode[$i]);
    }
    $implode = implode("\r\n\r\n", $explode);
    return $implode;
  }

  function br2nl($string) {
    return preg_replace('/\<br(\s*)?\/?\>/i', "\n", $string);
  }

  function shorten_desc($description){
    $description = br2nl($description);
    $count = str_word_count($description);
    $description = implode(' ', array_slice(explode(' ', $description), 0, 10));
    if(strlen($description) > 80) {
      $description = substr($description, 0, 80);
    }
    if($count > 10){
      $description .= ' (...)';
    }

    return $description;
  }

  function redirect($url) {
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';

    echo $string;
  }

  /****************************END OF LOGIN SCRIPT FUNCTIONS*********************************/
  /*regular site functions*/

  function get_header($n = 1) {
    include(str_repeat('../', $n) . "include/header.php");
  }

  function get_footer($n = 1) {
    include(str_repeat('../', $n) . "include/footer.php");
  }

  /**
  * Send a POST requst using cURL
  * @param string $url to request
  * @param array $post values to send
  * @param array $options for cURL
  * @return string
  */
  function curl_post($url, array $post = NULL, array $options = array()) {
    $defaults = array(
      CURLOPT_POST => 1,
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_CONNECTTIMEOUT => 20,
      CURLOPT_TIMEOUT => 20,
      CURLOPT_POSTFIELDS => http_build_query($post)
    );

    $ch = curl_init();
    curl_setopt_array($ch, ($options + $defaults));
    if (!$result = curl_exec($ch)) {
      trigger_error(curl_error($ch));
    }
    curl_close($ch);
    return $result;
  }


  /*Notifications function (removes extra unnecessary code from PHP pages)*/
  function notifications() {
    echo
        '<div id="notifications">
        <div class="notification-arrow-up"></div>
        <div id="notification-body">
          <div id="notification-header">
            <b>Notifications:</b>
              <a href="javascript:;" style="float: right; margin-right: 2vw;" onClick="mark_all_read('.$_SESSION['user_id'].')">Mark all read</a>
          </div>';
          if (count($notification_data) == 0) {
          echo '
          <a href="javascript:;">
          <div id="notification-0" class="notification read">
            <div class="notification-color" style="background-color: #ccc"></div>
            <div class="notification-text">No notifications</div>
          </div>
          </a>';
          } else {
            foreach ($notification_data as $notif) {
              $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
              echo '
              <a href="'.$notif_data['url'].'" onClick="mark_read('.$notif['id'].')">
              <div id="notification-'.$notif['id'].'" class="notification ';
              if ($notif['read'] == 0) { echo 'unread'; } else { echo 'read'; }
              echo
              '">
              <div class="notification-color" style="background-color: #'.$notif_data['data']['color'].'">'.substr($notif_data['data']['location'], 0, 1).'</div>
              <div class="notification-text">
                '.$notif_data['data']['subject'].'
              </div>
              <p class="time">
                 '.date('D M d, Y g:i a', $notif['timestamp']).'
              </p>
            </div>
          </a>';
            }
          }
          echo '
          <div id="notification-footer">
            <a href="http://everythingdojo.com/notifications.php">See All</a>
          </div>
        </div>
      </div>';
  }


  function notificationData() {
    global $notification;
    global $notification_data;
    global $unread_count;
    if ($_SESSION['user_id'] != NULL) {
      $unread_count = $notification->count_unread($_SESSION['user_id']);
      $notification_data = $notification->get_notifications($_SESSION['user_id']);
    }
  }


  function gravatar($user_id) {
    $row = get_user_info($user_id);
    $email = $row['user_email'];
    $hash = md5(strtolower(trim($email)));
    $avatar = "http://www.gravatar.com/avatar/".$hash."?d=identicon";
    return $avatar;
  }

?>
