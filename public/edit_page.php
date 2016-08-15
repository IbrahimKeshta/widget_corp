<?php require_once("../includes/session.php");  ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php $find_selected_page = find_selected_page();?>
<?php $current_subject = $find_selected_page[0];
    $current_page = $find_selected_page[1];
    ?>

<?php 
  if(!$current_page) {
    // Subject ID was Missing or nivalid or
    // Subject couldn't be found in database
    redirect_to("manage_content.php");
  }
?>
<?php 
  if(isset($_POST["submit"])){
      // IF submitted successful 
      
      // validation
      $require_feilds = array("menu_name" , "position" , "visible" , "content");
      validate_presences($require_feilds);

      $fields_with_max_lengths = array("menu_name" => 30);
      validate_max_length($fields_with_max_lengths);

    if(empty($errors)){
      
      // Perform Update query 
      // Proccess the form
      $subject_id= $current_page["subject_id"];
      $id        = $current_page["id"];
      $menu_name = mysql_prep($_POST["menu_name"]);
      $position  = (int) $_POST["position"];
      $visible   = (int) $_POST["visible"];
      $content = mysql_prep($_POST["content"]);

      $query  = "UPDATE pages SET ";
      $query .= "menu_name='{$menu_name}', " ;
      $query .= "position='{$position}', " ;
      $query .= "visible='{$visible}', " ;
      $query .= "content='{$content}' " ;
      $query .= "WHERE id='{$id}' AND subject_id='{$subject_id}' ";
      $query .= "LIMIT 1";
      $result = mysqli_query($connection , $query);
    var_dump($result);
      if($result && mysqli_affected_rows($connection) >= 0){
        //Success 
        $_SESSION["message"] = "Page Updated.";
        redirect_to("manage_content.php");
      }else{
      // Failure
      $message = "Page Updated failed.";
      }
   }
  }else{
    //this probably a GET request
    // if not show the same form below again
  }  // end of : if(isset($_POST["submit"]))
?>

<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation"> 
  <!-- 
  here will show the subjects and the pages of each subject --> 
  <?php echo navigation($current_subject , $current_page); ?>
  </div>
  <div id="page">
  <?php // $message is just a variable, doesn't use the SESSION
    if(!empty($message)) {
      echo "<div class=message >" . htmlentities($message) . "</div>";
    } 
  ?>
  <?php //we are in the same page we don't need to call $errors() :function
  echo form_errors($errors); ?>

  <h2>Edit Page : <?= htmlentities($current_page["menu_name"]);?></h2>
    <form action="edit_page.php?page=<?= urlencode($current_page["id"]);?>" method="post">
     <p>Menu name: 
          <input type="text" name="menu_name" value="<?= htmlentities($current_page["menu_name"]);?>">
         </p>
         <p>Position: 
          <select name="position">
          <?php
            $page_set = find_pages_for_subject($current_page["subject_id"]);
            $page_count = mysqli_num_rows($page_set);
            // count will be <= subject_count not + 1 cuz we don't add new subject
            for($count=1; $count<= $page_count;$count++){
              echo "<option value=\"{$count}\"";
              if($current_page["position"] == $count ){
              echo " selected";
            }
              echo ">{$count}</option>";
            }
          ?>
          </select>
         </p>
          <p>Visible: 
          <input type="radio" name="visible" value="0" <?php if($current_page["visible"] == 0) {echo "checked";} ?>> No
          &nbsp;
          <input type="radio" name="visible" value="1" <?php if($current_page["visible"] == 1) {echo "checked";} ?>> Yes
         </p>
         <p>
          <textarea name="content" rows="20" cols="80"><?= htmlentities($current_page["content"]); ?></textarea>
         </p>
         <input type="submit" name="submit" value="Edit Page">
    </form>
    <br> 
    <a href="manage_content.php">Cancel</a>
    &nbsp;
    <a href="delete_page.php?page=<?= urlencode($current_page["id"]); ?>" onclick="return confirm('Are you sure?');">Delete Page</a> 
    </div>
</div>

<?php /*
  if(isset($_SERVER["REQUEST_METHOD"])){
      if($_POST["edit"]){
    $menu_name = $_POST["menu_name"];
    $query  = "UPDATE subjects ";
    $query .= " SET menu_name='{$menu_name}'" ;
    $query .= "WHERE id='{$current_subject["id"]}'";
    $result = mysqli_query($connection , $query);
    if($result){
      //Success 
      $_SESSION["message"] = "Subject Edited.";
      redirect_to("manage_content.php");
    }else{
      // Failure
      $_SESSION["message"] = "Subject Editing failed.";
      redirect_to("edit_subject.php");
    }
  }

  }

*/?>
<?php include("../includes/layouts/footer.php"); ?>
