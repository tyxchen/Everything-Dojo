<?php
//get topics
  if (empty($_GET['f'])) {
    exit("Topic not found: we couldn't find your topic because it doesn't exist. Don't worry, though; Try going <a href='index.php'>back to Discuss home page</a> or try our other services!");
  } else {
    //check if special
    if ($_GET['f'] == 1) {
      $topic = $discuss->get_topic(intval($_GET['t']), 1);
      $posts = $discuss->get_posts(intval($_GET['t']), 'all', 1);
      $typearg = 1;
    } else {
      $topic = $discuss->get_topic(intval($_GET['t']));
      $posts = $discuss->get_posts(intval($_GET['t']), 'all', 0);
      $typearg = 0;
    }
  }
  if (!empty($_SESSION['user_id'])) {
    if ($_GET['f'] == 1) {
      $type = 0;
    } else if (intval($_GET['f']) == 4) {
      if ($_SESSION['user_level'] < 3){
        echo "<meta http-equiv=\"refresh\" content=\"0;URL=/index.php\">";
      }
    } else {
      $type = 1;
    }
    $discuss->view_topic(intval($_GET['t']), $type, intval($_SESSION['user_id']));
  }
  $data = $discuss->get_fora(intval($topic['forum_id']));
?>

<?php if (!empty($topic) && !empty($topic['title'])) { ?>
<a href="<?php echo URL_DISCUSS; ?>?view=forum&f=<?php echo intval($topic['forum_id']);?>">&laquo; Back to <?php echo $data['name'];?></a>
<section id="topic" style="margin-top: 1em;">
  <div id="discuss-topic-header">
    <h1 style="text-align:center;"><?php echo $topic['title']; if (intval($_GET['f']) == 0) {echo " (archived)";}?></h1>
  </div>
  <div id="topic-main">
    <?php if (isset($_GET["unicorns"])) { ?><img class="avatar" src=<?php echo "\"http://unicornify.appspot.com/avatar/" . md5(get_all_user(intval($post["user_id"]))["user_email"]) . "?s=128\"" ?> ><?php } ?>
    <div class="topic-text" id="topic-main-text">
      <?php $user = get_user(intval($topic['user_id'])); ?>
      <h2 style="display:inline-block; margin-right:0.5em;"><?php echo $topic['title'];?></h2>
      <div style="display:inline-block; opacity: 0.6;">Posted by <?php echo $user;?> on <?php echo date('M d, Y g:i a', $topic['time']);?></div>
      <?php if (($_SESSION['user_id'] == $topic['user_id']) || ($_SESSION['user_level']) >= 3) { ?>
      <?php if ($_SESSION['user_level'] >= 3 && $typearg != 1) { ?>
      <div class="topic-reply-panel">
        <div class="topic-top-archive" id="topic-top-archive"><img alt="Archive Topic" src="/images/trash.png" style="width: 0.55em; height: 0.75em;"> Archive Topic</div><div class="topic-top-move" id="topic-top-move">&rArr; Move Topic</div><div class="topic-top-sticky" id="topic-top-sticky" style="border-right: 0 solid #000000;<?php if(intval($topic['type'] == 2)) echo 'background-color:#509aff;color:#fff;'; ?>" >&#x2605; <?php if (intval($topic['type']) == 2) { echo "Unsticky Topic"; } else { echo "Sticky Topic"; } ?></div>
      </div>
      <script>
        $('#topic-top-move').on('click', function(e) {
          var loc = prompt("Choose forum_id to move to.\n2) Feature Requests\n3) Bug Reports\n4) Archives");
          $.post('../include/discuss/topic_ajax.php', {action: 'move', id: <?php echo intval($topic['topic_id']); ?>, location: loc, mode: <?php echo $typearg; ?>}, function(data) {
            if (data == "good"){
              window.location.href = 'index.php?view=topic&f='+loc+'&t=<?php echo $topic['topic_id'];?>';
            }
            else{
              alert("Something wrong happened. Please try again.");
            }
          });
        });
        $('#topic-top-sticky').on('click', function(e) {
          $.post('../include/discuss/topic_ajax.php', {action: 'sticky', id: <?php echo intval($topic['topic_id']); ?>, mode: <?php echo $typearg; ?>}, function(data) {
            if (data == "good"){
              window.location.reload();
            }
            else{
              alert(data+"Something wrong happened. Please try again.");
            }
          });
        });
        $('#topic-top-archive').on('click', function(e) {
          $.post('../include/discuss/topic_ajax.php', {action: 'move', id: <?php echo intval($topic['topic_id']); ?>, location: 4, mode: <?php echo $typearg; ?>}, function(data) {
            if (data == "good"){
              window.location.href = 'index.php?view=topic&f=4&t=<?php echo $topic['topic_id'];?>';
            }
            else{
              alert("Something wrong happened. Please try again.");
            }
          });
        });
      </script>
      <?php }
      } ?>
      <p><?php echo $topic['text'];?></p>
      <?php if($topic['edit_id'] > 0){ ?><p class="small">Last edited by <?php echo get_user($topic['edit_id']); ?> on <?php echo date('M d, Y g:i a', $topic['last_timestamp']);?></p><?php } ?>
    </div>
  </div>
  <?php if (!empty($posts)) { ?>
    <?php $thankedposts = [];
    // indice starts at 1 since get_posts deletes the first element (the root post)
    for ($i = 1; $i <= sizeof($posts); $i++) {
      $post = $posts[$i];?>
      <div class="topic-reply" id="<?php echo "$i"; ?>">
        <?php if (isset($_GET["unicorns"])) { ?><img class="avatar" src=<?php echo "\"http://unicornify.appspot.com/avatar/" . md5(get_all_user(intval($post["user_id"]))["user_email"]) . "?s=128\"" ?>><?php } ?>
        <div class="topic-text topic-reply-text" <?php if($post == end($posts)) echo 'id="last"'; ?>>
          <?php $user = get_all_user($post['user_id']);?>
          <div class="topic-reply-top" <?php if ($post['type'] == 1){ echo "style=\"padding:0.35em;\""; }?> >
            <?php if ($post['type'] == 0) {?>
            <h2 style="display:inline-block; margin-right:0.5em;"><?php echo $post['title'];?></h2>
            <div style="display:inline-block; opacity: 0.6;">
              Posted by <?php echo $user['user_name'];?> on <?php echo date('M d, Y g:i a', $post['time']);?></div>
            <?php if (($_SESSION['user_id'] > 0)) { ?>
            <div class="topic-reply-panel">
              <?php $thanks = $discuss->thanks($post['post_id'], $typearg, $_SESSION['user_id']); ?>
              <?php if ($_SESSION['user_id'] != $user['id']){?><div class="topic-reply-thanks<?php if (in_array($_SESSION['user_id'],$thanks)){ echo " topic-reply-thanked"; $thankedposts[] = $post['post_id'];}?>" id="topic-reply-thanks-<?php echo $post['post_id'];?>" onclick="thankpost(<?php echo $post['post_id']?>)">&uArr; &nbsp;&nbsp;<?php echo count($thanks);?> Thank<?php if (count($thanks) != 1){echo "s";}?></div><?php } else if ($_SESSION['user_id'] == $user['id']) {echo "<div class=\"topic-reply-disabled\">".count($thanks)." Thank"; if (count($thanks) != 1){echo "s";} echo "</div>"; echo "<div class=\"topic-reply-edit\" id=\"topic-reply-edit-".$post['post_id']."\"><img alt=\"Edit Post\" src=\"/images/edit.png\" style=\"width: 0.75em; height: 0.75em;\"> Edit Post</div>";} if ($_SESSION['user_level'] >= 3) {if ($_SESSION['user_id'] != $user['id']) {echo "<div class=\"topic-reply-edit\" id=\"topic-reply-edit-".$post['post_id']."\"><img alt=\"Edit Post\" src=\"/images/edit.png\" style=\"width: 0.75em; height: 0.75em;\"> Edit Post</div>";} echo "<div class=\"topic-reply-delete\" id=\"topic-reply-delete-".$post['post_id']."\"><img alt=\"Delete Post\" src=\"/images/trash.png\" style=\"width: 0.55em; height: 0.75em;\"> Delete Post</div>"; echo "<div class=\"topic-reply-cleanthanks".((count($thanks) > 0) ? "" : " topic-reply-disabled")."\" id=\"topic-reply-cleanthanks-".$post['post_id']."\"".((count($thanks) > 0) ? "" : " disabled=\"disabled\"").">&dArr; Clear Thanks</div>";} //this php tho ?>
            </div>
            <?php } else { ?>
            <?php $thanks = $discuss->thanks($post['post_id'], $typearg); ?>
            <div style="opacity: 0.6; text-decoration: italic; display:inline-block; margin-left: 2em;"><?php echo count($thanks);?> Thank<?php if (count($thanks) != 1){echo "s";}?></div>
            <?php
                  }
                }
            ?>
          </div>
          <?php
            if ($post['type'] == 0) {
              echo "<div id='topic-reply-message-".$post['post_id']."'>".$post['text']."</div>";
            }
            else{
              echo
                "<div id='topic-reply-messageD-".$post['post_id']."' style='opacity: 0.6'>
                  <h2>Deleted Post</h2>
                  <p>This post was deleted by ".get_user($post['edit_id'])." on ".date('M d, Y g:i a', $post['last_timestamp']).".</p>
                </div>";
            }
          ?>
            <?php if (!empty($post['edit_id'])) { if($post['edit_id'] > 0 && $post['type'] == 0){ ?><p class="small">Last edited by <?php echo get_user($post['edit_id']); ?> on <?php echo date('M d, Y g:i a', $post['last_timestamp']);?></p><?php }} ?>
          <?php
            if (($_SESSION['user_id'] == $user['id']) || $_SESSION['user_level'] >= 5){
              echo
              "
              <form id='topic-reply-edit-box-".$post['post_id']."'>
                <div class=\"field\" id=\"msg-reply-edit-field-".$post['post_id']."\" style=\"margin-top: 0;\">
                  <div class=\"field split left\">
                    Edit Comment: <a href=\"https://help.github.com/articles/github-flavored-markdown\" title=\"Github Flavored Markdown\" style=\"color:#777;font-size:.8em;line-height:2em\" target=\"_blank\" tabindex=\"1\">(Parsed with Github Flavored Markdown)</a>
                    <br/>
                    <textarea placeholder='Write your new comment here...' style='height:200px; vertical-align:top;' name='desc-source' id='topic-reply-edit-desc-source-".$post['post_id']."'>".trim($post['text'])."</textarea>
                    <input type=\"hidden\" name=\"desc\" />
                  </div>
                  <div class=\"field split right\">
                    <div class=\"topic-text\" name=\"preview\"></div>
                  </div>
                </div>
                <input type=\"button\" value=\"Cancel\" class=\"danger cancel\" id=\"cancel-edit-".$post['post_id']."\" />
                <input type=\"button\" value=\"Edit\" disabled id=\"post-edit-".$post['post_id']."\" class=\"post-edit\" />
                <br/>
                <br/>
              </form>
              <span class='msg warn' id='msg-reply-edit-errors-".$post['post_id']."' style='padding:0.6em'>No errors yet.</span>
              <script>
              \$('#topic-reply-message-".$post['post_id']."').html(marked(\$('#topic-reply-message-".$post['post_id']."').text(), markedOptions));
              \$('#msg-reply-edit-errors-".$post['post_id']."').hide();
              \$('#topic-reply-edit-box-".$post['post_id']."').hide();
              \$('#topic-reply-edit-".$post['post_id'].", #cancel-edit-".$post['post_id']."').on('click', function() {
                \$('#topic-reply-message-".$post['post_id']."').slideToggle(300);
                \$('#topic-reply-edit-box-".$post['post_id']."').slideToggle(300);
              });
              ";
              if ($_SESSION['user_level'] >= 3){
                echo "
                \$('#topic-reply-cleanthanks-".$post['post_id']."').on('click', function(e) {
                  \$.post('../include/discuss/topic_ajax.php', {action: 'clear_thanks', id: ".intval($post['post_id']).", mode: ".intval($typearg)."}, function(data) {
                    if (data == \"good\"){
                      window.location.reload();
                    }
                    else{
                      alert(\"Something wrong happened. Please try again.\");
                    }
                  });
                });

                \$('#topic-reply-delete-".$post['post_id']."').on('click', function(e) {
                  \$.post('../include/discuss/topic_ajax.php', {action: 'delete', id: ".intval($post['post_id']).", mode: ".intval($typearg)."}, function(data) {
                    if (data == \"good\"){
                      window.location.reload();
                    }
                    else{
                      alert(\"Something wrong happened. Please try again.\");
                    }
                  });
                });";
              }

              echo "\$('#post-edit-".$post['post_id']."').on('click', function(e) {
                  e.preventDefault();
                  if ($('#post-edit-".$post['post_id']."').prop('disabled') != true){
                    \$.post('../include/discuss/topic_ajax.php', {action: 'edit', id: ".intval($post['post_id']).", mode: ".intval($typearg).", text: $('#topic-reply-edit-desc-source-".$post['post_id']."').val()}, function(data) {
                      var data_words = 'Could not parse message.';
                      switch (data.substr(0,6)){
                        case 'unauth':
                          data_words = 'You are not authorized to use this feature on someone else\'s post.';
                          break;
                        case 'textov':
                          data_words = 'The message must have at least 10 characters (excluding whitespace).';
                          break;
                        case 'deaddb':
                          data_words = 'Couldn\'t connect to database for some reason. Try again later.';
                          break;
                        case 'samusr':
                          data_words = 'Edited your post successfully.';
                          \$('#topic-reply-message-".$post['post_id']."').html(marked(data.substr(8), markedOptions));
                          break;
                        case 'op_mod':
                          data_words = 'Edited ".get_user($post['user_id'])."\'s post successfully.';
                          \$('#topic-reply-message-".$post['post_id']."').html(marked(data.substr(8), markedOptions));
                          break;
                        default:
                          data_words = 'Could not parse message.';
                      }
                      \$('#topic-reply-message-".$post['post_id']."').slideToggle(300);
                      \$('#topic-reply-edit-box-".$post['post_id']."').slideToggle(300);
                      \$('#msg-reply-edit-errors-".$post['post_id']."').html(data_words).fadeIn(300).fadeOut(10000);
                      \$('#msg-reply-edit-field-".$post['post_id']."').animate({'margin-top': '4rem'},300).delay(8000).animate({'margin-top': '0rem'}, 2000);
                    });
                  }
                });
                </script>";
            }
          ?>
        </div>
        <?php echo "<a href='#".$i."' title='Permalink for comment #".$i."'".(($post['type'] == 0) ? "" : " style='text-decoration: line-through;'"). ">#".$i."</a>"; ?>
      </div>
    <?php
    } ?>
    <?php if ($_SESSION['user_id']) { ?>
    <script>
      var thankedPosts = [<?php echo implode(",", $thankedposts); ?>];
      function thankpost(post_id) {
        if ($.inArray(post_id, thankedPosts) >= 0) {
          $.post("../include/discuss/topic_ajax.php", {action: "thank", mode: <?php if (intval($_GET['f']) == 1) { echo "3"; } else { echo "2"; } ?>, id: post_id}, function(data) {
            if (data.substr(0,7) == "success") {
              $('#topic-reply-thanks-'+post_id).html("&uArr; &nbsp;&nbsp;"+data.substr(8)+" Thanks");
              $('#topic-reply-thanks-'+post_id).removeClass('topic-reply-thanked');
              thankedPosts.pop($.inArray(post_id, thankedPosts));
            } else {
              alert("We can't un-thank the post for some reason. Check your internet connection.");
            }
          });
        } else {
          $.post("../include/discuss/topic_ajax.php", {action: "thank", mode: <?php if (intval($_GET['f']) == 1) { echo "3"; } else { echo "2"; } ?>, id: post_id}, function(data) {
            if (data.substr(0,7) == "success") {
              $('#topic-reply-thanks-'+post_id).html("&uArr; &nbsp;&nbsp;"+data.substr(8)+" Thanks!");
              $('#topic-reply-thanks-'+post_id).addClass('topic-reply-thanked');
              thankedPosts.push(post_id);
            } else {
              alert("We can't thank the post for some reason. Check your internet connection.");
            }
          });
        }
      }
    </script>
    <?php }
    } ?>
</section>
<br/>
  <?php
  if (!empty($_SESSION['err'])) {
    echo '<div id="errors">';
    foreach($_SESSION['err'] as $error) {
      echo '<p class="invalid">' . $error . '</p><br />';
    }
    echo '</div>';
  }
  unset($_SESSION['err']);
  ?>
<?php if ($_SESSION['user_id'] > 0) { ?>
<a id="topic-a-comment">+ Add a comment</a>
<fieldset id="topic-create-comment">
<legend>Add new comment</legend>
<form action="index.php" method="post" id="form">
  <div class="field" style="display:none">
    Title: <input type="text" name="title" value="RE: <?php echo $topic['title'];?>" /><br/>
  </div>
  <div class="field">
    <div class="field split left">
      Comment: <a href="https://help.github.com/articles/github-flavored-markdown" title="Github Flavored Markdown" style="color:#777;font-size:.8em;line-height:2em" target="_blank" tabindex="1">(Parsed with Github Flavored Markdown)</a>
      <br />
      <textarea name="desc-source" placeholder="Write your comment here..." style="vertical-align:top; height:200px;"></textarea>
      <input type="hidden" name="desc" />
    </div>
    <div class="field split right">
      <div class="topic-text" name="preview"></div>
    </div>
  </div>
  <input type="button" value="Cancel" class="danger cancel" id="cancel" />
  <input type="button" value="Comment" id="post" disabled />
  <input type="hidden" name="forum" value="<?php echo $topic['forum_id'];?>" />
  <input type="hidden" name="mode" value="post">
  <input type="hidden" name="t" value="<?php echo $topic['topic_id'];?>" />
  <input type="submit" style="display:none" />
</form>
</fieldset>

<script>
  $("#topic-create-comment").hide();
  $("#topic-a-comment").click(function(){
    $("#topic-a-comment").hide();
    $("#topic-create-comment").slideToggle(300);
  });
  $("#cancel").click(function () {
    $("#topic-a-comment").show();
    $("#topic-create-comment").slideToggle(300);
  });
  $("#post").click(function () {
    $("[name='desc']").val($("[name='preview']").html());
    $("#form").submit();
  });
</script>
<?php }
} else {
  echo "<h1 style='text-align:center;'>Topic Not Found</h1>";
  echo "<p style='text-align:center;'>The topic you were looking for is not found. Don't worry, though; Try going <a href='index.php'>back to Discuss home page</a> or try our other services!</p>";
}
?>
