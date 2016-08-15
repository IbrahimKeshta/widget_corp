<?php require_once("../includes/session.php");  ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php $find_selected_page = find_selected_page();?>
<?php $current_subject = $find_selected_page[0];
    $current_page = $find_selected_page[1];
    ?>

<?php 
  if(!$current_subject) {
    // Subject ID was Missing or nivalid or
    // Subject couldn't be found in database
    redirect_to("manage_content.php");
  }
?>
<?php 
  if(isset($_POST["submit"])){
    // IF submitted successful 
    // Proccess the form
    $subject_id = (int) $_GET["subject"];
    $menu_name = mysql_prep($_POST["menu_name"]);
    $position  = (int) $_POST["position"];
    $visible   = (int) $_POST["visible"];
    $content   = mysql_prep($_POST["content"]);

    // validation
    $require_feilds = array("menu_name" , "position" , "visible","content");
    validate_presences($require_feilds);

    $fields_with_max_lengths = array("menu_name" => 30);
    validate_max_length($fields_with_max_lengths);

    if(!empty($errors)){
      $_SESSION["errors"] = $errors;
      redirect_to("new_page.php?subject=$subject_id");
    }
      
    // Perform database query 
    
    $query  = "INSERT INTO pages (";
    $query .= " subject_id , menu_name , position , visible , content ) ";
    $query .= " VALUES ( {$subject_id} , '{$menu_name}' , {$position} , {$visible} , '{$content}')";
    $result = mysqli_query($connection , $query);
    if($result){
      //Success 
      $_SESSION["message"] = "Page Created.";
      redirect_to("manage_content.php");
    }else{
      // Failure
      $_SESSION["message"] = "Page creation failed.";
      redirect_to("new_page.php?subject=$subject_id");
    }


  }else{
    //this probably a GET request
    // if not show the same form below again
  } // end of : if(isset($_POST["submit"])){
?>
 <?php
  //if (isset($connection)) { mysqli_close($connection); }
  ?>
<?php include("../includes/layouts/header.php"); ?>

<div id="main">
	<div id="navigation">	
	<!-- 
	here will show the subjects and the pages of each subject -->	
	<?php echo navigation($current_subject , $current_page); ?>
	</div>
	<div id="page">
	<?php echo message(); ?>
	<?php $errors = errors();
	echo form_errors($errors); ?>
	<h2>Create Page</h2>
		<form action="new_page.php?subject=<?= urlencode($current_subject['id']); ?>" method="post">
     <p>Menu name: 
          <input type="text" name="menu_name" value="">
         </p>
         <p>Position: 
          <select name="position">
          <?php
          	$page_set = find_pages_for_subject($current_subject["id"]);
          	$page_count = mysqli_num_rows($page_set);
          	for($count=1; $count<= ($page_count)+1;$count++){
          		echo "<option value=\"{$count}\">{$count}</option>";
          	}
          ?>
          </select>
         </p>
         <p>
          <p>Visible: 
          <input type="radio" name="visible" value="0"> No
          &nbsp;
          <input type="radio" name="visible" value="1"> Yes
         </p>
         <p>
           <textarea name="content" rows="20" cols="80"></textarea>
         </p>
         <input type="submit" name="submit" value="Create Page">
		</form>
    <br>
		<a href="manage_content.php?subject=<?= urlencode($current_subject['id']);?>">Cancel</a><br>
    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
