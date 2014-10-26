<?php
  $title = "Database";
  include("../include/include.php");
  include("../include/themedb.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"/css/prism.min.css\" />
  <link rel=\"stylesheet\" href=\"/css/database.min.css\" />";
  $extra_js = "<script src=\"/js/prism.min.js\"></script>
  <script src=\"/js/database.js\"></script>";
  if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
  } else {
    $mode = 'index';
  }
  get_header(1);

  if ($_SESSION['user_id'] != NULL) {
    $unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }
?>
<section id="content">
  <div id="notifications">
    <div class="notification-arrow-up"></div>
    <div id="notification-body">
      <div id="notification-header">
        <b>Notifications:</b>
          <a href="javascript:;" style="float: right; margin-right: 2vw;" onClick="mark_all_read(<?php echo $_SESSION['user_id']; ?>)">Mark all read</a>
      </div>
      <?php if (count($notification_data) == 0) { ?>
      <a href="javascript:;">
      <div id="notification-0" class="notification-item read">
        <div class="notification-color" style="background-color: #ccc"></div>
        <div class="notification-text">No notifications</div>
      </div>
      </a>
      <?php
      } else {
        foreach($notification_data as $notif) {
          $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
      ?>
      <a href="<?php echo $notif_data['url']; ?>" class="notification-item-link" onClick="mark_read(<?php echo $notif['id']; ?>)">
        <div id="notification-<?php echo $notif['id']; ?>" class="notification-item <?php if($notif['read'] == 0){ echo 'unread'; }else{ echo 'read'; } ?> ">
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
      <div id="notification-footer">
        <a href="/notifications.php">See All</a>
      </div>
    </div>
  </div>
        <div id="navigation">
          <nav class="db-nav">
            <ul>
              <li><a href="/" id="nav-home">EvDo Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="javascript:;" class="notification-link" onClick="show_notifications()">Notifications (<?php echo $unread_count; ?>)</a></li>
            <?php } ?>
            </ul>
          </nav>
        </div>
  <?php
  if (!isset($_SESSION['user_id'])) {
    include('../include/themedb/view_body.php');
    // end guest case
  } else {
    switch ($mode) {
      case 'index':
        include('../include/themedb/index_body.php');
        if ($_SESSION['user_level'] == 5) {
          echo '<div class="mcp-link-wrapper"><a href="' .  URL_DATABASE . '?mode=mcp" class="mcp-link">ThemeDB Moderator CP</a></div>';
        }
        break;

      case 'submit':
        echo '<a href="' . URL_DATABASE . '">Back to Database Index</a>';
        include('../include/themedb/submit_body.php');
        break;

      case 'manage':
        echo '<a href="' . URL_DATABASE . '">Back to Database Index</a>';
        include('../include/themedb/manage_body.php');
        break;

      case 'view':
        if ($_GET['view'] != '') {
          echo '<a href="' . URL_DATABASE . '">Database Index</a> >> <a href="' . URL_DATABASE . '?mode=view">View Options</a>';
        }
        include('../include/themedb/view_body.php');
        break;

      case 'mcp':
        if ($_SESSION['user_level'] == 5) {
          echo '<a href="' . URL_DATABASE . '">Back to Database Index</a>';
          include('../include/themedb/mcp_body.php');
        } else {
          if ($_GET['view'] != '') {
            echo '<a href="' . URL_DATABASE . '">Database Index</a> >> <a href="' . URL_DATABASE . '?mode=view">View Options</a>';
          }
          include('../include/themedb/view_body.php');
        }
        break;

      case 'edit':
        echo '<a href="' . URL_DATABASE . '">Database Index</a> >> <a href="' . URL_DATABASE . '?mode=view">View Options</a>';
        include('../include/themedb/edit_body.php');
        break;

      case 'settings':
        echo '<a href="' . URL_DATABASE . '">Database Index</a> >> <a href="' . URL_DATABASE . '?mode=view">View Options</a>';
        include('../include/themedb/settings_body.php');
        break;

    // end user mode
    }
  } ?>
</section>
<?php get_footer(1); ?>
