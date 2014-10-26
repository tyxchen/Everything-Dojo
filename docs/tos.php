<?php
  $title = "Terms of Service";
  include("../include/include.php");
  session_start();
  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }
  get_header(1);
?>
<section id="content">
  <h1>Terms of Service</h1>
  <p class="small">Last updated October 26, 2014</p>
  <p class="large">Everything Dojo is a student-led, student-run open-source project which exists to serve the users of AoPS by assisting them in choosing and customizing CSS codes for their blogs. As such, we'd like to keep it a comfortable, safe environment. By using the Everything Dojo site and the services we offer, you agree to follow the rules on this page. Since we'd like to keep it safe for everybody, we reserve all rights to terminate your ability to use this site and services if you violate the rules.</p>

  <h2>Your Account</h2>
  <p>To use certain services we offer, you need to create an account on the site. It's your responsibility to keep your username and password safe, and make sure your email is correct so that we can contact you if we need. If your account is hacked, it's also your responsibility to let us know as soon as you suspect it's happened, so that we can try and fix the issue for you and protect others' accounts as well.</p>
  <p>You're responsible for anything that happens under your account's name, regardless of if it was you or someone else who had access to your account somehow (little siblings, anyone?).</p>
  <p>You can't have more than one account per person, and "bot" accounts are also not permitted.</p>
  <p>If you're under 13, <em>please</em> let a parent or guardian know that you're registering an account/giving us information (let them read the <a href="privacy.php">Privacy Policy</a>). It's the law.</p>

  <h2>Content you post</h2>
  <p>By submitting, posting, or displaying content on Everything Dojo, you're telling us these things are true:</p>
  <ul>
    <li>The content is free, open-source stuff that is licensed under the <a href="http://opensource.org/licenses/MIT">MIT License</a>.</li>
    <li>Anyone can fork the content and modify it and use it anywhere, given, of course, no plagiarism or making money off of it, etc.</li>
    <li>The content doesn't violate any copyrights or infringe any other intellectual property rights.</li>
    <li>The content is not deceptive or misleading.</li>
    <li>The content doesn't contain any personal/private information that you don't have permission to give.</li>
    <li>The content doesn't contain or link any viruses/trojan horses/etc.; things that are meant to hack and be generally damaging to either people's computers, the server, or other things of that nature.</li>
    <li>The content obeys the <a href="conduct.php">Code of Conduct</a> to the best of its ability.</li>
  </ul>
  <p>All content is the responsbility of the original owner/creator of it, and anything that happens because of it is not Everything Dojo's fault.</p>
  <p>Everything Dojo aims to be a place in which CSS codes can be collected together, but we cannot make any guarantees about keeping everything safe. If for some reason the database gets hacked or a lightning bolt strikes down the computer hosting the server or someone accidentally clicks delete on everything, your stuff is gone. In summary, don't rely on Everything Dojo to be the only place in which your things are stored; back them up somewhere else. If we are going to intentionally delete any sort of content we've collected from you, we'll give you fair warning and let you know before we do it.</p>

  <h2>Privacy Policy</h2>
  <p>In order to serve you better, Everything Dojo may collect some information from you. If you'd like to know what that information is and how we use it, you can read about it in the <a href="privacy.php">Privacy Policy</a>. We promise to follow this to the best of our ability and we'll not let anyone work for this site if they don't follow the rules.</p>

  <h2>Code of Conduct</h2>
  <p>It's important to us to maintain a comfortable, safe environment in which our users can thrive. As part of these Terms and Conditions, you agree to follow the <a href="conduct.php">Code of Conduct</a> to the best of your ability. If you make a couple mistakes, that's okay. We're all human. We'll probably correct the objectionable action and let you know not to do it again. However, if you display an inability to follow this Code of Conduct on multiple counts, Everything Dojo reserves the right to ban you or take other reasonable measures.</p>

  <h2>Lastly...</h2>
  <p>We reserve the rights to change these terms at any time. We'll let you know if we change anything and if there's anything new to read.</p>
  <p>If you have any concerns, objections, suggestions for modification, or other comments about these Terms, please drop us a line by using our <a href="/contact.php">contact form</a>.</p>
</section>

<?php get_footer(1); ?>
