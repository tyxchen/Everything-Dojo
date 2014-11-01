<?php
class theme_unapproved {
  public $id;

  function __construct($item_id) {
    $this->id = $item_id;
  }

  function get_data() {
    $data = array(
      'subject'  => 'Sorry, your theme was not approved.',
      'color'    => 'D553CB',
      'location' => 'Database'
    );
    return $data;
  }

  function get_url() {
    $url = URL_DATABASE . "?mode=view&view=style&id=" . $this->id;
    return $url;
  }
}
?>
