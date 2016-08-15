<?php 

// 1. Create a Database connection

 $dbhost = "localhost";
 $dbuser = "root";
 $dbpass = "";
 $dbname = "widget_cms";
 $connection = mysqli_connect($dbhost , $dbuser , $dbpass , $dbname );

 // test if connection succeeded
  
  if(mysqli_connect_errno()) {
  	die("Database Connection failed: " . mysqli_connect_error() . " ( " . mysqli_connect_errno . " ) "
  		);
  }

 ?>

 <?php 
 // 2. Perform database query
 
 $query  = "SELECT * ";
 $query .= "FROM subjects ";
 $query .= "WHERE visible = 1 ";
 $query .= "ORDER BY position ASC" ;
 $result = mysqli_query($connection , $query);
 // test if there was query error
 if(!$result) {
 	die("Database query failed.");
 }
 ?>


<ul>
 <?php
 // 3. Use returned data (if any)
 
 while($subject = mysqli_fetch_assoc($result)){
 	// output data from each row
 ?>
 <li><?php echo $subject["menu_name"] . " ( " . subject["id"] . ")"; ?></li>
 <?php
	}
 ?>
 </ul>

 <?php
 // 4. Release returned data
  mysqli_free_result($result);
  ?>

  <?php 
  // 5. close database connection
  mysqli_close($connection);
  ?>