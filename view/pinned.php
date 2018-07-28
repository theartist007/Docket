<?php
include ("connect.php");
include("functions.php");
if(!logged_in())("Location: login.php");

$id = isset($_GET['id']) ? $_GET['id'] : '';

$sql="UPDATE tasks
SET pin = CASE WHEN id='$id' and pin = 1 Then 0
WHEN id='$id' and pin = 0 Then 1
ELSE pin
END";

$result = mysqli_query($con, $sql) or die("Unable to pin the task.");
$name = $_SESSION['username'];
$sqlresult = mysqli_query($con, "SELECT * FROM tasks WHERE name='$name' and pin=1") or die ("Unable to query tasks");

								while($Row = mysqli_fetch_array($sqlresult)){
									$pin=$Row['pin'];
									$id = $Row['id'];
									echo "<div class='list-li clearfix'>
									<div class='info pull-left'>
									<div class='name'>".$Row['task']."<br>Date of Creation : ".$Row['dateofcreation']."</div>
									</div><p class='name'><br><br>&nbsp;&nbsp;Date of Completion : ";
															echo $Row['dateofcompletion'];
          													echo '</p><div class="action pull-right"><a id="edit_task"  onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
									echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star"></i></a>';
									echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a></div></div>';


								}
$sqlresult = mysqli_query($con, "SELECT * FROM tasks WHERE name='$name' and pin=0") or die ("Unable to query tasks");

								while($Row = mysqli_fetch_array($sqlresult)){
									$pin=$Row['pin'];
									$id = $Row['id'];
									echo "<div class='list-li clearfix'>
									<div class='info pull-left'>
									<div class='name'>".$Row['task']."<br>Date of Creation : ".$Row['dateofcreation']."</div>
									</div><p class='name'><br><br>&nbsp;&nbsp;Date of Completion : ";
															echo $Row['dateofcompletion'];
          													echo '</p><div class="action pull-right"><a id="edit_task"  onclick="edit(\''.$Row['id'].'\')"><i class="fa fa-edit"></i></a>';
									echo '<a id="pinned_task" onclick="pinned(\''.$Row['id'].'\')"><i class="fa fa-star-o"></i></a>';
									echo '<a id="remove_task" onclick="remove(\''.$Row['id'].'\')"><i class="fa fa-trash-o"></i></a></div></div>';


								}

?>