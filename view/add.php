<?php
include ("connect.php");
include("functions.php");
if(!logged_in())("Location: login.php");

$name = $_SESSION['username'];

if(isset($_POST['task']) && isset($_POST['genre']) && isset($_POST['dateofcreation']) && isset($_POST['dateofcompletion'])){

	$modtime = date('Y-m-d G:i:s');
    $task = mysqli_real_escape_string($con, $_POST['task']);
    $dateofcreation = mysqli_real_escape_string($con, $_POST['dateofcreation']);
    $dateofcompletion = mysqli_real_escape_string($con, $_POST['dateofcompletion']);
    $genre = mysqli_real_escape_string($con, $_POST['genre']);
    $insertQuery = "INSERT INTO tasks(task, name, genre, modtime, dateofcreation,dateofcompletion) VALUES ('$task', '$name', '$genre', '$modtime', '$dateofcreation','$dateofcompletion')";
	if(isset($_POST['id'])){
        $id = $_POST['id'];
        $insertQuery = "UPDATE tasks SET task ='$task',genre = '$genre',modtime='$modtime',dateofcreation='$dateofcreation',dateofcompletion='$dateofcompletion' WHERE id = '$id'";
    }
    if(mysqli_query($con, $insertQuery)){
        $error = "Note added";
    }
    else{
        $error = "Cannot add task!!";
    }
}

$query = "SELECT * FROM tasks WHERE name='$name' and pin=1 ORDER BY task";

if(isset($_POST['sortby']) && $_POST['sortby']!='All'){
  $sortby = mysqli_real_escape_string($con, $_POST['sortby']);
  $query = "SELECT * FROM tasks WHERE name='$name' and genre = '$sortby' and pin=1 ORDER BY task";

}
$sqlresult = mysqli_query($con, $query) or die ("Unable to query tasks");

while($Row = mysqli_fetch_array($sqlresult)){
	$id = $Row['id'];
	echo "<div class='list-li clearfix'>
          <div class='info pull-left'>
            <div class='name'>".$Row['task']." <br>Date of Creation :  ".$Row['dateofcreation']."</div>
          </div><p class=text-primary><br>|| Date of Completion : ";
															echo $Row['dateofcompletion'];
          													echo '</p><div class="action pull-right">
            <a id="edit_task" onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
       	  echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star"></i></a>';
          echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a>
          </div>
  </div>';
}


$query = "SELECT * FROM tasks WHERE name='$name' and pin=0 ORDER BY task";

if(isset($_POST['sortby']) && $_POST['sortby']!='All'){
  $sortby = mysqli_real_escape_string($con, $_POST['sortby']);
  $query = "SELECT * FROM tasks WHERE name='$name' and genre = '$sortby' and pin=0 ORDER BY task";

}
$sqlresult = mysqli_query($con, $query) or die ("Unable to query tasks");

while($Row = mysqli_fetch_array($sqlresult)){
	$id = $Row['id'];
	echo "<div class='list-li clearfix'>
          <div class='info pull-left'>
            <div class='name'>".$Row['task']." <br>Date of Creation : ".$Row['dateofcreation']."</div>
          </div><p class='name'><br><br>&nbsp;&nbsp;Date of Completion : ";
															echo $Row['dateofcompletion'];
          													echo '<div class="action pull-right">
            <a id="edit_task" onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
           echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star-o"></i></a>';
		   echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a>
          </div>
  </div>';
}



?>