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
          <nav>
            <?php if (isset($_SESSION['user_id'])) {
              global $notification;
              $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
              $notification_data = array_reverse($notification->get_notifications($_SESSION['user_id'], 1000, TRUE));
            ?>
            <div class="user"><img src="<?php echo gravatar($_SESSION['user_id']); ?>"><span class="user-notification-status<?php if (isset($notification_unread_count) && $notification_unread_count > 0) echo ' new'; ?>"></span><span class="user-info"><?php echo $_SESSION['user_name'] . (isset($notification_unread_count) ? "&nbsp;(<span class='notification-unread-count'>$notification_unread_count</span>)" : ""); ?></span>
              <div class="user-menu">
                <ul class="user-menu-inner">
                  <li><a href="javascript:;" onclick="$(this).parent().next().slideToggle(400);$(this).toggleClass('expanded');" class="menu-link menu-notification-toggle">Notifications <?php if (isset($notification_unread_count)) { echo "(<span class='notification-unread-count'>$notification_unread_count</span>)"; } ?></a></li>
                  <div class="menu-notification" style="display:none">
                    <?php if (count($notification_data) == 0) { ?>
                    <div id="menu-notification-0" class="menu-notification-item menu-notification-none">
                      <div class="menu-notification-text">No new notifications</div>
                    </div>
                    <?php } else { ?>
                    <a href="javascript:;" onClick="mark_all_read('<?php echo $_SESSION['user_id'] ?>')" class="menu-link menu-notification-mark-all-read">Mark all read</a>
                    <div class="menu-notification-body">
                      <?php
                      for ($i = 0; $i < count($notification_data); $i++) {
                        if ($i > 2) break;
                        if ($notification_data[$i]['read'] != 0) {
                          continue;
                        } else {
                          $notif = $notification_data[$i];
                        }
                        $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
                      ?>
                        <div id="menu-notification-<?php echo $notif['id']; ?>" class="menu-notification-item menu-notification-unread" style="border-left: 3px solid #<?php echo $notif_data['data']['color']; ?>">
                          <a href="<?php echo $notif['url']; ?>" class="menu-link menu-notification-text">
                            <?php echo $notif_data['data']['subject']; ?>
                          </a>
                          <p class="time"><?php echo date('D M d, Y g:i a', $notif['timestamp']); ?></p>
                          <span class="menu-notification-mark-read" onclick="mark_read(<?php echo $notif['id']; ?>)" title="Mark as read">&#x2713;</span>
                        </div>
                      <?php } ?>
                      <div class="menu-notification-footer">
                        <a href="/notifications.php" class="menu-link menu-notification-link">See All<?php print ($notification_unread_count - 3 > 0) ? ("<span class='notification-left-unread-count'>&nbsp;(" . ($notification_unread_count - 3) . ")</span>") : ""; ?></a>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <hr>
                  <li><a href="/myaccount.php" class="menu-link menu-myaccount">My Account</a></li>
                  <li><a href="/mysettings.php" class="menu-link menu-mysettings">My Settings</a></li>
                  <?php if ($_SESSION['user_level'] >= 5) echo '<li><a href="/admin.php" class="menu-link menu-admincp">Admin CP</a></li>'; ?>
                  <hr>
                  <li><a href="/" class="menu-link menu-home">EvDo Home</a></li>
                  <li><a href="/logout.php" class="menu-link menu-logout">Logout</a></li>
                </ul>
              </div>
            </div>
            <?php } ?>
          </nav>
      </header>

      <?php } elseif ($title == "Discuss") { ?>

      <header class="discuss">
        <section id="headerwrap">
          <a href="<?php echo URL_DISCUSS; ?>"><h1>Discuss</h1></a>
          <nav>
            <?php if (isset($_SESSION['user_id'])) {
              global $notification;
              $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
              $notification_data = array_reverse($notification->get_notifications($_SESSION['user_id'], 1000, TRUE));
            ?>
            <div class="user"><img src="<?php echo gravatar($_SESSION['user_id']); ?>"><span class="user-notification-status<?php if (isset($notification_unread_count) && $notification_unread_count > 0) echo ' new'; ?>"></span><span class="user-info"><?php echo $_SESSION['user_name'] . (isset($notification_unread_count) ? "&nbsp;(<span class='notification-unread-count'>$notification_unread_count</span>)" : ""); ?></span>
              <div class="user-menu">
                <ul class="user-menu-inner">
                  <li><a href="javascript:;" onclick="$(this).parent().next().slideToggle(400);$(this).toggleClass('expanded');" class="menu-link menu-notification-toggle">Notifications <?php if (isset($notification_unread_count)) { echo "(<span class='notification-unread-count'>$notification_unread_count</span>)"; } ?></a></li>
                  <div class="menu-notification" style="display:none">
                    <?php if (count($notification_data) == 0) { ?>
                    <div id="menu-notification-0" class="menu-notification-item menu-notification-none">
                      <div class="menu-notification-text">No new notifications</div>
                    </div>
                    <?php } else { ?>
                    <a href="javascript:;" onClick="mark_all_read('<?php echo $_SESSION['user_id'] ?>')" class="menu-link menu-notification-mark-all-read">Mark all read</a>
                    <div class="menu-notification-body">
                      <?php
                      for ($i = 0; $i < count($notification_data); $i++) {
                        if ($i > 2) break;
                        if ($notification_data[$i]['read'] != 0) {
                          continue;
                        } else {
                          $notif = $notification_data[$i];
                        }
                        $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
                      ?>
                        <div id="menu-notification-<?php echo $notif['id']; ?>" class="menu-notification-item menu-notification-unread" style="border-left: 3px solid #<?php echo $notif_data['data']['color']; ?>">
                          <a href="<?php echo $notif['url']; ?>" class="menu-link menu-notification-text">
                            <?php echo $notif_data['data']['subject']; ?>
                          </a>
                          <p class="time"><?php echo date('D M d, Y g:i a', $notif['timestamp']); ?></p>
                          <span class="menu-notification-mark-read" onclick="mark_read(<?php echo $notif['id']; ?>)" title="Mark as read">&#x2713;</span>
                        </div>
                      <?php } ?>
                      <div class="menu-notification-footer">
                        <a href="/notifications.php" class="menu-link menu-notification-link">See All<?php print ($notification_unread_count - 3 > 0) ? ("<span class='notification-left-unread-count'>&nbsp;(" . ($notification_unread_count - 3) . ")</span>") : ""; ?></a>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <hr>
                  <li><a href="/myaccount.php" class="menu-link menu-myaccount">My Account</a></li>
                  <li><a href="/mysettings.php" class="menu-link menu-mysettings">My Settings</a></li>
                  <?php if ($_SESSION['user_level'] >= 5) echo '<li><a href="/admin.php" class="menu-link menu-admincp">Admin CP</a></li>'; ?>
                  <hr>
                  <li><a href="/" class="menu-link menu-home">EvDo Home</a></li>
                  <li><a href="/logout.php" class="menu-link menu-logout">Logout</a></li>
                </ul>
              </div>
            </div>
            <?php } ?>
          </nav>
        </section>
      </header>

      <?php } elseif ($title != "Themizer (Regular Mode)" && $title != "Themizer (Development Mode)" && $title !== "Try-It") { ?>

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
            <?php if (isset($_SESSION['user_id'])) {
              global $notification;
              $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
              $notification_data = array_reverse($notification->get_notifications($_SESSION['user_id'], 1000, TRUE));
            ?>
            <div class="user"><img src="<?php echo gravatar($_SESSION['user_id']); ?>"><span class="user-notification-status<?php if (isset($notification_unread_count) && $notification_unread_count > 0) echo ' new'; ?>"></span><span class="user-info"><?php echo $_SESSION['user_name'] . (isset($notification_unread_count) ? "&nbsp;(<span class='notification-unread-count'>$notification_unread_count</span>)" : ""); ?></span>
              <div class="user-menu">
                <ul class="user-menu-inner">
                  <li><a href="javascript:;" onclick="$(this).parent().next().slideToggle(400);$(this).toggleClass('expanded');" class="menu-link menu-notification-toggle">Notifications <?php if (isset($notification_unread_count)) { echo "(<span class='notification-unread-count'>$notification_unread_count</span>)"; } ?></a></li>
                  <div class="menu-notification" style="display:none">
                    <?php if (count($notification_data) == 0) { ?>
                    <div id="menu-notification-0" class="menu-notification-item menu-notification-none">
                      <div class="menu-notification-text">No new notifications</div>
                    </div>
                    <?php } else { ?>
                    <a href="javascript:;" onClick="mark_all_read('<?php echo $_SESSION['user_id'] ?>')" class="menu-link menu-notification-mark-all-read">Mark all read</a>
                    <div class="menu-notification-body">
                      <?php
                      for ($i = 0; $i < count($notification_data); $i++) {
                        if ($i > 2) break;
                        if ($notification_data[$i]['read'] != 0) {
                          continue;
                        } else {
                          $notif = $notification_data[$i];
                        }
                        $notif_data = $notification->get_notif_obj($notif['notification_type'], $notif['item_id']);
                      ?>
                        <div id="menu-notification-<?php echo $notif['id']; ?>" class="menu-notification-item menu-notification-unread" style="border-left: 3px solid #<?php echo $notif_data['data']['color']; ?>">
                          <a href="<?php echo $notif['url']; ?>" class="menu-link menu-notification-text">
                            <?php echo $notif_data['data']['subject']; ?>
                          </a>
                          <p class="time"><?php echo date('D M d, Y g:i a', $notif['timestamp']); ?></p>
                          <span class="menu-notification-mark-read" onclick="mark_read(<?php echo $notif['id']; ?>)" title="Mark as read">&#x2713;</span>
                        </div>
                      <?php } ?>
                      <div class="menu-notification-footer">
                        <a href="/notifications.php" class="menu-link menu-notification-link">See All<?php print ($notification_unread_count - 3 > 0) ? ("<span class='notification-left-unread-count'>&nbsp;(" . ($notification_unread_count - 3) . ")</span>") : ""; ?></a>
                      </div>
                    </div>
                    <?php } ?>
                  </div>
                  <hr>
                  <li><a href="/myaccount.php" class="menu-link menu-myaccount">My Account</a></li>
                  <li><a href="/mysettings.php" class="menu-link menu-mysettings">My Settings</a></li>
                  <?php if ($_SESSION['user_level'] >= 5) echo '<li><a href="/admin.php" class="menu-link menu-admincp">Admin CP</a></li>'; ?>
                  <hr>
                  <li><a href="/logout.php" class="menu-link menu-logout">Logout</a></li>
                </ul>
              </div>
            </div>
            <?php } else { ?>
            <ul id="actions-menu">
              <li><a href="/login.php" class="user-link menu-login">Login</a></li>
              <li><a href="/register.php" class="user-link menu-register">Register</a></li>
            </ul>
            <?php } ?>
          <?php } ?>
          </nav>

        </section>
      </header>

      <?php } ?>
