<?php
  $title = "Discuss";
  include("include/include.php");
  include("include/discuss.php");
  session_start();
  $extra_style = "<link rel=\"stylesheet\" href=\"css/discuss.css\" />";
  get_header();
  $view = $_GET['view'];
?>
<section id="content">
  <?php 
    $result = $dbc->prepare("SELECT data FROM data WHERE fetchname = 'announcements'");
    $result->execute();
    $result = $result->fetchAll(PDO::FETCH_ASSOC);

    $announcements = explode("~", $result[0]['data']);
  ?>
  <?php if (!empty($announcements[0])) {?>
  <section id="announcements">
    <h3>Announcements: </h3>
    <div class="discuss-round" id="discuss-round-left"><span class="discuss-round"></span></div>
    <div id="discuss-announcements">
    <?php 
      $key = 1;
      foreach($announcements as $announce) {
        echo "<div class=\"discuss-announcement\" id=\"discuss-announcement-".$key."\" style=\"display: block;\">".$announce."</div>";
        $key += 1;
      }
    ?>
    </div>
    <div class="discuss-round" id="discuss-round-right"><span class="discuss-round"></span></div>
      <script>
        var announcement_options = {
          num: <?php echo count($announcements);?>,
          start: 1,
          now: 1,
          aidPrefix: "discuss-announcement-",
          updateView: function () {
            for (ji = announcement_options.start; ji <= announcement_options.num; ji++) {
              $("#"+announcement_options.aidPrefix+ji).fadeOut(100);
            }
            $("#"+announcement_options.aidPrefix+announcement_options.now).delay(200).fadeIn(100);
          }
        }
        $(document).ready(function () {
          //start up
          for (ji = announcement_options.start; ji <= announcement_options.num; ji++) {
            $("#"+announcement_options.aidPrefix+ji).hide();
          }
          announcement_options.now = announcement_options.start;
          $("#"+announcement_options.aidPrefix+announcement_options.now).show();
        });

        $("#discuss-round-left").click(function () {
          if (announcement_options.now == announcement_options.start) {
            announcement_options.now = announcement_options.num;
          } else {
            announcement_options.now -= 1;
          }
          announcement_options.updateView();
        });

        $("#discuss-round-right").click(function () {
          if (announcement_options.now == announcement_options.num) {
            announcement_options.now = announcement_options.start;
          } else {
            announcement_options.now += 1;
          }
          announcement_options.updateView();
        });
      </script>        
    </section>
    <?php } ?>
    <br/>
    <?php
    switch($view){
      case '':
				echo '<a href="' . URL_DISCUSS. '">Back to Discuss Index</a>';
        include('include/discuss/index_body.php');
        break;
      case 'forum':
				echo '<a href="' . URL_DISCUSS. '">Back to Discuss Index</a>';
        include('include/discuss/forum_body.php');
        break;
      case 'topic':
        include('include/discuss/topic_body.php');
        break;
      default:
        echo "<b>Something wrong happened!</b> Discuss can't handle this request because it doesn't know how to do it! Don't worry, though; Try going <a href='discuss.php'>back to Discuss home page</a> or try our other services!";
        break;
    }
    ?>
</section>

<?php get_footer(); ?>
