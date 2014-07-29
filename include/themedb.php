<?php
/*
* Theme DB Version 1.0
* Methods
*/
class themedb {

  // Modifying/inserting methods

  function approve_theme() {
  }

  function submit_theme() {
  }

  // Getting methods

  function get_themes($id = 'all') {
		global $dbc;
		
    if($id == 'all') {
      // Select all approved themes but unvalidated
      $query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 1 AND `validated` = 0";

      // Assign themes to array
      $id          = array();
      $name        = array();
      $description = array();
      $stage       = array();
      $author      = array();
      $version     = array();
      $submit_id   = array();
      $owner_id    = array();
			
			foreach ($dbc->query($query) as $row) {
        $id[]          = $row["id"];
        $name[]        = $row["name"];
        $description[] = $row["description"];
        $stage[]       = $row["stage"];
        $author[]      = $row["author"];
        $version[]     = $row["version"];
        $submit_id[]   = $row["submited_by_id"];
        $owner_id[]    = $row["owner_id"];
			}

      $unvalidated = array(
          'id'          => $id,
          'name'        => $name,
          'description' => $description,
          'stage'       => $stage,
          'author'      => $author,
          'version'     => $version,
          'submit_id'   => $submit_id,
          'owner_id'    => $owner_id
      );
			

      // Select all approved themes and validated
      $query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `approved` = 1 AND `validated` = 1";

      // Assign themes to array
      $id          = array();
      $name        = array();
      $description = array();
      $stage       = array();
      $author      = array();
      $version     = array();
      $submit_id   = array();
      $owner_id    = array();
			
			foreach ($dbc->query($query) as $row) {
        $id[]          = $row["id"];
        $name[]        = $row["name"];
        $description[] = $row["description"];
        $stage[]       = $row["stage"];
        $author[]      = $row["author"];
        $version[]     = $row["version"];
        $submit_id[]   = $row["submited_by_id"];
        $owner_id[]    = $row["owner_id"];
			}
			
      $validated = array(
          'id'          => $id,
          'name'        => $name,
          'description' => $description,
          'stage'       => $stage,
          'author'      => $author,
          'version'     => $version,
          'submit_id'   => $submit_id,
          'owner_id'    => $owner_id
      );

      $data = array(
        'unvalidated' => $unvalidated,
        'validated'   => $validated
      );
			
      return $data;
    }
    else {
			$query = "SELECT * FROM " . THEMEDB_TABLE . " WHERE `id` = :id";
			$sth = $dbc->prepare($query);
			$sth->execute(array('id' => $id));
    	$result = $sth->fetch(PDO::FETCH_ASSOC);
			
			return $result;
		}
  }

}
$themedb = new themedb();
?>
