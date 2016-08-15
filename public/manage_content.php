<?php require_once("../includes/session.php");  ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php") ?>
<?php include("../includes/layouts/header.php"); ?>
<?php $find_selected_page = find_selected_page();?>
<?php $current_subject = $find_selected_page[0];
    $current_page = $find_selected_page[1];
    ?>

<div id="main">
	<div id="navigation">	
	 <br>
	 <a href="admin.php">&laquo; Main menu </a><br>
	<!-- 
	here will show the subjects and the pages of each subject -->	
	<?php echo navigation($current_subject , $current_page); ?> 
	<br>
	<a href="new_subject.php">+ Add a subject</a><br><br>
	</div>
	<div id="page">	
		<?php echo message(); ?>
	<?php 
		// reading subjects 
	if ($current_subject){ ?> 
			<h2>Manage Subject</h2>	
	   		 Menu name: <?= htmlentities($current_subject["menu_name"]); ?><br><br>
	   		 Position: <?=  $current_subject["position"];?><br><br>
	   		 Visible: <?= $current_subject["visible"] == 1 ? 'yes' : 'no' ;?><br><br>
	          <a href="edit_subject.php?subject=<?=	 urlencode($current_subject['id']); ?>">Edit Subject </a> 

	          <div style="margin-top:2em; border-top:1px solid #000000">
	          <h3>Pages in Subject: <?= htmlentities($current_subject["menu_name"]); ?></h3>
	          <ul>
	          <?php 
		          $subject_pages = find_pages_for_subject($current_subject["id"]);
		          while($page = mysqli_fetch_assoc($subject_pages)){
		          	echo "<li>";
		          	$safe_page_id = urlencode($page['id']);
		          	echo "<a href=manage_content.php?page={$safe_page_id}>" . htmlentities($page["menu_name"]) . "</a>";
		          	echo "</li>"; 
	         	    }
	          ?>	
	          <br>
	          	<a href="new_page.php?subject=<?= urlencode($current_subject['id']); ?>"> + Add new pages to this subject </a>
	 <?php }elseif ($current_page){ ?> 
	 	<h2>Manage Page</h2>
		Menu name: <?php echo htmlentities($current_page["menu_name"]) ; ?><br><br>
		Position: <?=  $current_page["position"];?><br><br>
		Visible: <?= $current_page["visible"] == 1 ? 'yes' : 'no' ;?><br><br>
		Content:<br>
		<div class="view-content">
			<?=  htmlentities($current_page["content"]);?>
			</div><br>
			 <a href="edit_page.php?page=<?= urlencode($current_page['id']); ?>">Edit page</a>
	 <?php }else { ?>
	 	<h2>Manage Content</h2>
		please Select subject or a page
	  <?php } ?> 

    </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
