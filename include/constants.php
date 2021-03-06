<?php
  /* CONSTANTS */

  /* Discuss Constants */
  define("DISCUSS_FORUM_TABLE", "discuss_forums");   //all the forums/groups
  define("DISCUSS_TOPIC_TABLE", "discuss_topics");   //all the topics/threads
  define("DISCUSS_POSTS_TABLE", "discuss_posts");    //all the posts and replies
  define("DISCUSS_POSTS_SPECIAL_TABLE", "discuss_posts_special");    //all the posts and replies for special topics
  define("DISCUSS_TOPICS_TRACK_TABLE", "discuss_topics_track");
  define("DISCUSS_TOPICS_TRACK_SPECIAL_TABLE", "discuss_topics_track_special");

  /* Miscellaneous Table Constants */
  define("THEMEDB_TABLE", "theme_database");
  define("USERS_TABLE", "users");

  /* URL Constants */
  define("URL_DATABASE", "/database");
  define("URL_DISCUSS", "/discuss");
  define("URL_THEMIZER", "/themizer");
  define("URL_TRYIT", "/tryit");
  define("SITE_ROOT", "http://rebuild.everythingdojo.com/");

  /* Version Constants */
  define("VERSION_DATABASE", "2.0.1");
  define("VERSION_DISCUSS", "2.0.1");
  define("VERSION_THEMIZER", "2.0.1");
  define("VERSION_TRYIT", "2.0.1");

  /* User Level Specifications */
  define ("ADMIN_LEVEL", 5);
  define ("USER_LEVEL", 1);
  define ("GUEST_LEVEL", 0);

  /* Password Salt Length */
  define('SALT_LENGTH', 9);
?>
