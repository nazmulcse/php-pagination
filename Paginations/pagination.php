<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title></title>
</head>
<body>
	<?php
	   $conn=mysqli_connect("localhost","root","","ecommerce");
        $per_page=4;
		  $pages=$_GET["page"];
		if($pages=="" || $pages==1)
		{
		  $pages1=0;
		  }
		 else
		 {
		   $pages1=($pages*$per_page)-$per_page;
		 }
	   $sql="SELECT * FROM 	tbl_category limit $pages1,$per_page";
	   $row=mysqli_query($conn,$sql);
	   while($res=mysqli_fetch_assoc($row))
	   {
	     echo $res["category_id"]."  ".$res["category_name"]."  ".$res["category_description"];
		 echo "<br/>";
	   }
	   $sql="SELECT * FROM 	tbl_category";
	   $row=mysqli_query($conn,$sql);
	   $total_rows=mysqli_num_rows($row);
	  $per_page=4;
	   $total_pages=ceil($total_rows/$per_page);
	   echo "<br/>";
	   
	   for($a=1;$a<=$total_pages;$a++)
	   {
	      ?>
		  <a href="pagination.php?page=<?php echo $a;?>" style="text-decoration:none;"><?php echo $a." ";?></a>
		  <?php
	   }
	?>
</body>
</html>