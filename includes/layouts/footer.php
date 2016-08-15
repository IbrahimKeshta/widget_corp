<div id="footer">Copyright <?= date("Y")?>, Widget Corp</div>
		
</body>
</html>
  <?php
  // 5. close database connection
  if(isset($connection)){
  mysqli_close($connection);
}
  ?>