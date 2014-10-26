<?php
  $title = "Privacy Policy";
  include("../include/include.php");
  session_start();
  if (isset($_SESSION['user_id'])) {
    $notification_unread_count = $notification->count_unread($_SESSION['user_id']);
    $notification_data = $notification->get_notifications($_SESSION['user_id']);
  }
  get_header(1);
?>
<section id="content">
  <h1>Privacy Policy</h1>
  <p class="small">Last updated October 26, 2014</p>
  <p class="large">In order to serve you better, Everything Dojo may collect some information from you (this is not equal to content you submit, which are forum posts and CSS codes). We don't collect more than we need; we take the privacy of our users very seriously. Here's what we collect and how we use it. Since the site is run by volunteers, please tell us right away if you see any staff member failing to honor this promise we make to you.</p>

  <h2>What we collect</h2>
  <p>In order to create an account, we ask for you to submit a username, email address, and password. If you choose to use the contact form, we also ask for a name and email address.</p>
  <p>All names and usernames are created by you and submitted by you. As far as we care, they can be totally fake (and we suggest you don't actually use your real name). The only personally identifying information we request from you is your email address.</p>
  <p>Anything we collect from you, you have specifically supplied. We don't use any analytics, cookies, or other things like that.</p>

  <h2>How we use and handle the information we collect</h2>
  <p>Your email address is used for:</p>
  <ul>
    <li>Computer-automated, human-free account activation and password-forget emails</li>
    <li>Important security updates and other mandatory notifications</li>
    <li>Contacting you about any issues concerning your account, your behavior, or behavior towards you</li>
    <li>(if you contact us through the contact form) Responding to your message and taking appropriate action</li>
  </ul>
  <p>In general, we will not use your email unless we need to. It is not publicly visible, nor will we ever share it with anybody.</p>
  <p>If you send us a message through the contact form, we will receive it privately. Unless you mark it as a personal support message, we may make the message public (though always anonymous). If you do mark it as personal support, your message will forever be our secret.</p>
  <p>When you register, your password is immediately securely hashed and stored in a MySQL database. Nobody knows what your password is except for you.</p>

  <h2>Other important things</h2>
  <p>We keep all your information as safe as possible, but we can't guarantee there won't be a data breach.</p>
  <p>You can alter your password through your account yourself, but you can't change your username or email. We plan to add support for you to change your email very soon, but if you need to change it urgently, contact us through our contact form. We don't take requests for changing your username on any condition unless personal information is in your username (e.g. your real name).</p>

  <h2>If you're under 13 years of age</h2>
  <p>Please tell a parent or guardian if you provide us with an email address. It's the law.</p>
  <p>A parent may, at any time, ask to review any information we've collected about a child and/or ask us to delete it. You may do this by contacting us through our <a href="/contact.php">contact form</a>.</p>

  <h2>Lastly...</h2>
  <p>We reserve the rights to change this privacy policy at any time. We'll let you know if we change anything and if there's anything new to read.</p>
  <p>If you have any concerns, objections, suggestions for modification, or other comments about this policy, please drop us a line by using our <a href="/contact.php">contact form</a>.</p>

</section>

<?php get_footer(1); ?>
