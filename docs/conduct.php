<?php
  $title = "Code of Conduct";
  include("../include/include.php");
  session_start();
  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }
  get_header(1);
?>
<section id="content">
  <h1>Code of Conduct</h1>
  <p class="small">Last updated October 26, 2014</p>
  <p class="large">Everything Dojo is a public community, and everybody is welcome to participate, regardless of who they are. As such, we want everybody to feel comfortable and safe. In order for that to happen, we ask that you follow these rules of conduct. We promise to enforce these to the best of our ability.</p>

  <h2>Public Actions</h2>
  <p>This code of conduct applies to all of the public actions you can take on Everything Dojo:</p>
  <ul>
    <li>Submitting a CSS code</li>
    <li>Messages submitted to the Discuss forum system</li>
    <li>Anything else in which you create something or directly communicate here on Everything Dojo or through Everything Dojo</li>
  </ul>

  <h2>What's unacceptable</h2>
  <p>If one of these adjectives applied to some public action, it's unacceptable.</p>
  <ul>
    <li>pornographic/sexual</li>
    <li>bigoted</li>
    <li>sexist</li>
    <li>racist</li>
    <li>rude</li>
    <li>attacking</li>
    <li>intimidating</li>
    <li>harrassing</li>
    <li>stalking</li>
    <li>disruptive</li>
    <li>offensive</li>
    <li>spam</li>
  </ul>
  <p>This isn't a complete list. You get the idea; don't be a jerk.</p>
  <p>As to swearing, that's a different matter. We will censor swearing to the best of our ability, but we won't prevent you from doing it. (That's your freedom of expression, so's to speak.)</p>

  <h2>Who decides what's unacceptable?</h2>
  <p>The Staff of Everything Dojo gets to decide what is unacceptable; we get to make the final calls. We know there's some subjectivity involved, but we will try to err on the side of keeping the community comfortable and safe.</p>
  <p>Remember, you don't get to decide how other people feel about what you do.</p>

  <h2>What happens when an unacceptable action has happened?</h2>
  <p>Everything Dojo will first try our best to remove any unacceptable content, and if warranted, back it up and send it to the original owner. If it's serious enough, we'll let you know by email that you shouldn't do it again.</p>
  <p>We understand that everybody's human and makes a slip-up every now and then. However, if you display an inability to correct yourself and you continue to violate the rules on multiple counts, we will ban you. It's for the community.</p>

  <h2>How do I report an unacceptable action?</h2>
  <p>Use our <a href="/contact.php">contact form</a>. Please select the personal support label, and clearly state that the Code of Conduct has been violated.</p>

  <h2>Lastly...</h2>
  <p>If you have any concerns, objections, suggestions for modification, or other comments about this Code of Conduct, please drop us a line by using our <a href="/contact.php">contact form</a>.</p>

  <br />

  <p class="small">Thanks to CodePen for the outline of this Code of Conduct.</p>

</section>

<?php get_footer(1); ?>
