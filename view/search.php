<?php
include ("connect.php");
include("functions.php");
if(!logged_in())("Location: login.php");

$name = $_SESSION['username'];
$text = isset($_GET['search'])? $_GET['search'] : '';
if($text == '')
$sqlresult = mysqli_query($con, "SELECT * FROM tasks WHERE name='$name'")
 or die ("Unable to query tasks");

else
$sqlresult = mysqli_query($con, "SELECT * FROM tasks WHERE name='$name'
 AND task LIKE '%$text%'")  or die ("Unable to query tasks");


while($Row = mysqli_fetch_array($sqlresult)){
	$id = $Row['id'];
	$pin=$Row['pin'];
	echo "<div class='list-li clearfix'>
          <div class='info pull-left'>
            <div class='name'>".$Row['task']." TAGGED FOR :: ".$Row['date']."</div>
          </div><p class=text-primary><br>|| Last Moditfied on: ";
															echo $Row['modtime'];
          													echo '</p><div class="action pull-right">
            <a id="edit_task" onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
             if($pin==1)
		           	 {
		          	 	 echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star"></i></a>';
		         	     }
		         	     else
		         	     {
		         	         echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star-o"></i></a>';
		         	     }


          echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a>
          </div>
  </div>';
}
?>