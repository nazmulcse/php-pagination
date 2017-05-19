<?php
$conn=mysqli_connect("localhost","root","","ecommerce");
if(!$conn){
	echo "Database Error";
}
$sql="SELECT COUNT(category_id) FROM tbl_category";
$query=mysqli_query($conn,$sql);
$row=mysqli_fetch_row($query);
$row=$row[0];
$perpage=3;
$last=ceil($row/$perpage);
if($last<1)
	$last=1;
$pagenum=1;
if(isset($_GET['pn'])){
	$pagenum=$_GET['pn'];
}
if($pagenum<1){
	$pagenum=1;
}
else if($pagenum>$last){
	$pagenum=$last;
}
$limit='LIMIT '.($pagenum-1)*$perpage.','.$perpage;
$sql="SELECT * FROM tbl_category $limit";
$query=mysqli_query($conn,$sql);
$textline="Page $pagenum of $last";
$paginationCtrls='';
if($last>1){
	if($pagenum>1){
		$previous=$pagenum-1;
		$paginationCtrls.='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$previous.'"><<</a> &nbsp; &nbsp;';
		for($i=$pagenum-4;$i<$pagenum;$i++){
			if($i>0)
				$paginationCtrls.='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;';
		}
	}
	$paginationCtrls.=''.$pagenum.'&nbsp';
	for($i=$pagenum+1;$i<=$last;$i++){
		$paginationCtrls.='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$i.'">'.$i.'</a> &nbsp;';
		if($i>=$pagenum+4)
			break;
	}
	if($pagenum!=$last){
		$next=$pagenum+1;
		$paginationCtrls.='<a href="'.$_SERVER['PHP_SELF'].'?pn='.$next.'">>></a> &nbsp; &nbsp;';
	}
}
 echo $textline.'<br/>';
   while($res=mysqli_fetch_array($query,MYSQLI_ASSOC))
	   {
	     echo $res["category_id"]."  ".$res["category_name"]."  ".$res["category_description"];
		 echo "<br/>";
	   }
 echo $paginationCtrls;
?>