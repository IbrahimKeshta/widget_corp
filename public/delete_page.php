<?php require_once("../includes/session.php");  ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php") ?>


<?php 
$current_page = find_page_by_id($_GET["page"]);
if(!$current_page) {
  // Subject ID was Missing or nivalid or
  // Subject couldn't be found in database
  redirect_to("manage_content.php");
}

  $id     = $current_page["id"];
  $query  = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection , $query);
  if($result && mysqli_affected_rows($connection) == 1){
    //Success 
    $_SESSION["message"] = "Pages Deleted.";
    redirect_to("manage_content.php");
  }else{
    // Failure
    $_SESSION["message"] = "Page Deletion failed.";
    redirect_to("manage_content.php?page={$id}");
  }




?>
<?php include("../includes/layouts/footer.php"); ?>
