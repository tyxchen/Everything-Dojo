<!DOCTYPE html>
<html>

  <head>

    <title>Everything Dojo &bull; <?php global $title; print $title; ?></title>

    <meta charset="utf-8">
    <link href="images/favicon.ico" rel="shortcut icon">
    <link href="css/normalize.css" type="text/css" rel="stylesheet">
    <link href="css/style.css" type="text/css" rel="stylesheet">
    
    <?php global $extra_style; print $extra_style; ?>

    <?php
    // we don't need jQuery on some pages
    if ($title != "Home" || $title != "About") { ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/script.js"></script>
    <?php } ?>
    <?php 
    if ($title == "Try-It") { ?>
    <link href='css/tryit.css' rel='stylesheet' type='text/css'>
    <?php } ?>

    <?php global $extra_js; print $extra_js; ?>

    <noscript>
      <link href="css/noscript.css" type="text/css" rel="stylesheet">
    </noscript>

  </head>

  <body>

    <?php // is there a better way to do this?
    $pages = array("Home", "About", "Account Activation", "Forgot Password", "Logout Successful", "403", "404", "418", "500");
    if(!in_array($title, $pages))
      include("error/noscript.php");
    ?>

    <div id="wrap">

      <header>

        <div id="headerwrap">

          <?php if ($title == "Database") { ?>

          <script>$("header").addClass("database");</script>
          <h1>Database</h1>

          <?php } elseif ($title == "Themizer") { ?>

          <script>$("header").addClass("themizer");</script>
          <h1>Themizer</h1>

          <?php } elseif ($title == "Try-It") { ?>

          <script>$("header").addClass("tryit");</script>
          <h1>Try-It</h1>
          
          <form method="get" id="select-theme" name="select-theme" style="margin-left:200px; padding-top:20px;">
            <select id="select" name="select">
            <?php
              include("db.php");
              include("themedb.php");
              $data = $themedb->get_themes();
              //cache the theme id
              $ids = $data['validated']['id'];
              $names = $data['validated']['name'];
              foreach ($names as $key => $theme) {
	            echo '<option id="'.$ids[$key].'" name="'.$ids[$key].'" value="'.$ids[$key].'">'.$theme.'</option>';
              }
            ?>
            </select>
            <input type="submit" id="select-submit" name="select-submit" value="Go!" class="tryit-button"/>
          </form>
          <?php } elseif ($title == "Discuss") { ?>

          <script>$("header").addClass("discuss");</script>
          <h1>Discuss</h1>

          <?php } else { ?>

          <div id="logo">
            <a href="/"><img src="/images/logo.svg" alt="Logo" /></a>
          </div>

          <nav>
            <ul>
              <li><a href="/" id="nav-home">Home</a></li>
            <?php if(isset($_SESSION['user_id'])) { ?>
              <li><a href="myaccount.php" id="menu-myaccount">My Account</a></li>
              <li><a href="mysettings.php" id="menu-mysettings">My Settings</a></li>
              <?php
              // will not work if dbc is not included on page
              if (checkAdmin()) {
              ?>
              <li><a href="admin.php" id="menu-admin">Admin CP</a></li>
              <?php } //end admin ?>
              <li><a href="logout.php" id="menu-logout">Logout</a></li>
            <?php } ?>
            <?php if(!isset($_SESSION['user_id'])) { ?>
              <li><a href="login.php" id="menu-login">Login</a></li>
              <li><a href="register.php" id="menu-register">Register</a></li>
            <?php } ?>
            </ul>
          </nav>

          <?php } ?>

        </div>

      </header>

      <div id="content">

