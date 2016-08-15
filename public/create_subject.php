<?php require_once("../includes/session.php");  ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php 
	if(isset($_POST["submit"])){
		// IF submitted successful 
		// Proccess the form
		$menu_name = mysql_prep($_POST["menu_name"]);
		$position  = (int) $_POST["position"];
		$visible   = (int) $_POST["visible"];

		// validation
		$require_feilds = array("menu_name" , "position" , "visible");
		validate_presences($require_feilds);

		$fields_with_max_lengths = array("menu_name" => 30);
		validate_max_length($fields_with_max_lengths);

		if(!empty($errors)){
			$_SESSION["errors"] = $errors;
			redirect_to("new_subject.php");
		}
			
		// Perform database query 
		
		$query  = "INSERT INTO subjects (";
		$query .= " menu_name , position , visible ) ";
		$query .= " VALUES ( '{$menu_name}' , {$position} , {$visible} )";
		$result = mysqli_query($connection , $query);
		if($result){
			//Success 
			$_SESSION["message"] = "Subject Created.";
			redirect_to("manage_content.php");
		}else{
			// Failure
			$_SESSION["message"] = "Subject creation failed.";
			redirect_to("new_subject.php");
		}


	}else{
		//this probably a GET request
		redirect_to("new_subject.php");
	}
?>
 <?php
  if (isset($connection)) { mysqli_close($connection); }
  ?>