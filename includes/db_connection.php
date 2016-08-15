
<?php 

define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "widget_cms");

// 1. Create a Database connection

 $connection = mysqli_connect(DB_SERVER, DB_USER , DB_PASS , DB_NAME );

 // test if connection succeeded
  
  if(mysqli_connect_errno()){
  	die("Database Connection failed: " . mysqli_connect_error() . " ( " . mysqli_connect_errno . " ) "
  		);
  }

 ?>