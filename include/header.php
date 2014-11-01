<!DOCTYPE html>
<html>

  <head>

    <title>Everything Dojo &bull; <?php global $title; print $title; ?></title>

    <meta charset="utf-8">
    <link href="/images/favicon.ico" rel="shortcut icon">
    <link rel="apple-touch-icon-precomposed" href="/images/apple-touch-icon.png">
    <?php if ($title != "Themizer (Regular Mode)" && $title != "Themizer (Development Mode)" && $title != "Try-It") { ?>
    <link href="/css/normalize.min.css" rel="stylesheet">
    <link href="/css/fonts.min.css" rel="stylesheet">
    <link href="/css/style.min.css" rel="stylesheet">
    <?php } ?>
    <?php global $extra_style; print $extra_style; ?>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="/js/script.js"></script>
    <?php global $extra_js; print $extra_js; ?>

    <noscript>
      <link href="/css/noscript.min.css" rel="stylesheet">
    </noscript>

  </head>

  <body>

    <?php if (!in_array($title, array(
        "Home",
        "About",
        "Account Activation",
        "Forgot Password",
        "Logout Successful",
        "403",
        "404",
        "410",
        "418",
        "500"
      ))) {
      include("error/noscript.php");
    } ?>

    <main id="wrap">

      <?php if ($title == "Database") { ?>

      <header class="database">
        <section id="headerwrap">
          <a href="<?php echo URL_DATABASE; ?>"><h1>Database</h1></a>

          <?php
          global $mode;

          if ($mode == "view") { ?>
            <div class="search-container">
              <script src="/js/highlight.min.js"></script>
              <script src="/js/db-search.js"></script>
              <input class="search" type="text" placeholder="Search...">
              <div class="icon-box">
                <span class="search-icon"></span>
              </div>
            </div>
          <?php } ?>

        </section>
      </header>

      <?php } elseif ($title == "Discuss") { ?>

      <header class="discuss">
        <section id="headerwrap">
          <a href="<?php echo URL_DISCUSS; ?>"><h1>Discuss</h1></a>
        </section>
      </header>

      <?php } elseif ($title != "Themizer (Regular Mode)" && $title != "Themizer (Development Mode)" && $title !== "Try-It") { ?>

      <?php global $notification_unread_count; ?>

      <header>
        <section id="headerwrap">

          <nav class="breadcrumbs">
            <div id="logo">
              <a href="/"><?php print isset($_GET['unicorns']) ? '<img src="/images/unicorns.png" alt="Unicorns" style="margin-top:1rem" />' : '<img src="/images/logo.svg" alt="Logo" />'; ?></a>
            </div>
            <?php if ($title != "Home" && $title != "Discuss" && $title != "Database" && $title != "Themizer Index") {
              echo "<h1 class='big'>> $title</h1>";
            } elseif ($title == "Themizer Index") {
              echo "<h1 class='big'>> Themizer</h1>";
            } ?>
          </nav>

          <?php if ($title == "Themizer Index") { ?>
          <nav>
            <ul>
              <li><a onclick="$('#features').scrollTo()">Features</a></li>
              <li><a onclick="$('#changelog').scrollTo()">Changelog</a></li>
              <li><a onclick="$('#roadmap').scrollTo()">Roadmap</a></li>
            </ul>
          </nav>
          <?php } else { ?>
          <nav>
            <?php if(isset($_SESSION['user_id'])) {
              global $notification;
              $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
              $notification_data = $notification->get_notifications($_SESSION['user_id'], 1000);
            ?>
            <div class="user"><img src="<?php echo gravatar($_SESSION['user_id']); ?>"><span class="user-notification-status<?php if (isset($notification_unread_count) && $notification_unread_count > 0) echo ' new'; ?>"></span><span class="user-info"><?php echo $_SESSION['user_name'] . (isset($notification_unread_count) ? "&nbsp;(<span class='notification-count'>$notification_unread_count)</span>" : ""); ?></span>
              <div class="user-menu">
                <ul class="user-menu-inner">
                  <li><a href="javascript:;" onclick="$(this).parent().next().toggle();$(this).toggleClass('hover');" class="user-link menu-notification">Notifications <?php if (isset($notification_unread_count)) { echo "(<span class='notification-count'>$notification_unread_count</span>)"; } ?></a></li>
                  <div class="menu-notifications" style="display:none">
                    <?php if (count($notification_data) == 0) { ?>
                    <a href="javascript:;" class="user-link menu-notification-link menu-notification-none">
                      <div id="menu-notification-0" class="menu-notification-item menu-notification-none">
                        <div class="menu-notification-text">No notifications</div>
                      </div>
                    </a>
                    <?php } else {
                      echo '<a href="javascript:;" onClick="mark_all_read(' . $_SESSION['user_id'] . ')" class="user-link menu-notification-link menu-notification-mark-all-read">Mark all read</a>';
                    ?>
                    <div class="menu-notification-body">
                    <?php
                      for ($i = 0; $i < count($notification_data); $i++) {
                        if ($i >= 5) break;
                        $notif = $notification_data[$i];
                        $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
                      ?>
                      <a href="<?php echo $notif_data['url']; ?>" class="user-link menu-notification-link" onClick="mark_read(<?php echo $notif['id']; ?>)">
                        <div id="menu-notification-<?php echo $notif['id']; ?>" class="menu-notification-item <?php if($notif['read'] == 0){ echo 'menu-notification-unread'; }else{ echo 'menu-notification-read'; } ?> ">
                          <div class="menu-notification-text">
                            <?php echo $notif_data['data']['subject']; ?>
                          </div>
                          <p class="time">
                             <?php echo date('D M d, Y g:i a', $notif['timestamp']); ?>
                          </p>
                        </div>
                      </a>
                      <?php } ?>
                      <div id="notification-footer">
                        <a href="notifications.php" class="user-link menu-notification-link">See All<?php print (count($notification_data) - 5 > 0) ? ("&nbsp;(" . (count($notification_data) - 5) . ")") : ""; ?></a>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <hr>
                  <li><a href="/myaccount.php" class="user-link menu-myaccount">My Account</a></li>
                  <li><a href="/mysettings.php" class="user-link menu-mysettings">My Settings</a></li>
                  <?php if ($_SESSION['user_level'] >= 5) echo '<li><a href="/admin.php" class="user-link menu-admincp">Admin CP</a></li>'; ?>
                  <hr>
                  <li><a href="/logout.php" class="user-link menu-logout">Logout</a></li>
                </ul>
              </div>
            </div>
            <?php } else { ?>
            <ul id="actions-menu">
              <li><a href="/login.php" class="menu-link menu-login">Login</a></li>
              <li><a href="/register.php" class="menu-link menu-register">Register</a></li>
            </ul>
            <?php } ?>
            <script>
              $(".user").click(function () {
                $(this).toggleClass("user-active");
                $(".user-menu").toggle();
              });
              $(".user-menu").click(function (e) {
                e.stopPropagation();
              });
            </script>
          <?php } ?>
          </nav>

        </section>
      </header>

      <?php } ?>
