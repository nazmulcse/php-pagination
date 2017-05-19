<?php
$conn=mysqli_connect("localhost","root","","ecommerce");
if(!$conn){
	echo "Database Error";
}
$sql="SELECT COUNT(category_id) FROM tbl_category";
$query=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($query);
//here we have the total row count
$row=$row[0];
//this is the number of result we want to display perpage;
$page_rows=3;
//this tells us the page number of our last page
$last=ceil($row/$page_rows);
//this make sure that $last cannot be less than 1
if($last<1){
	$last=1;
}
//Established pagenum variable;
$pagenum=1;
//Get pagenum from URL if it is present, else it is 1;
if(isset($_GET['pn'])){
	$pagenum=preg_replace('#[^0-9]#','',$_GET['pn']);
	//$pagenum=$_GET['pn'];
}
//This check that pagenum isn't below 1 or more than $last;
if($pagenum<1)
	$pagenum=1;
else if($pagenum>$last)
	$pagenum=$last;
//this sets the range of rows to query for the chosen $pagenum;
$limit='LIMIT ' .($pagenum-1)*$page_rows.','.$page_rows;
$sql="SELECT * FROM tbl_category $limit";
$query=mysqli_query($conn,$sql);
$textline="Page <b>$pagenum</b> of <b>$last</b>";
//Established the $paginationCtrls Variable;
$paginationCtrls='';
if($last!=1){
	if($pagenum>1){
		$previous=$pagenum-1;
		$paginationCtrls.='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'">Previous</a> &nbsp; &nbsp;';
		//render clickable number link that shoud appear on the left of the targated page number;
		for($i=$pagenum-4;$i<$pagenum;$i++){
			if($i>0)
			  $paginationCtrls.='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;';
		}
	}
	//Render the targated page number, but without it being link;
	$paginationCtrls.=''.$pagenum.'&nbsp;';
	//render clickable number link that shoud appear on the right of the targated page number;
	for($i=$pagenum+1;$i<=$last;$i++){
		$paginationCtrls.='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;';
		if($i>=$pagenum+4)
			break;
	}
	if($pagenum!=$last){
		$next=$pagenum+1;
		$paginationCtrls.='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">Next &nbsp;';
	}
}
 echo $textline.'<br/>';
   while($res=mysqli_fetch_array($query,MYSQLI_ASSOC))
	   {
	     echo $res["category_id"]."  ".$res["category_name"]."  ".$res["category_description"];
		 echo "<br/>";
	   }
 echo $paginationCtrls;